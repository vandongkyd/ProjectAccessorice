package com.example.khoavx.accessoriceshop;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import com.google.android.material.snackbar.Snackbar;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.ButtonBarLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.recyclerview.widget.ItemTouchHelper;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RelativeLayout;
import android.widget.Toast;

import com.braintreepayments.api.dropin.DropInActivity;
import com.example.khoavx.accessoriceshop.Apdater.CartAdapter;
import com.example.khoavx.accessoriceshop.Database.ModelDB.Cart;
import com.example.khoavx.accessoriceshop.Model.Invoice;
import com.example.khoavx.accessoriceshop.Retrofit.ICallShopAPI;
import com.example.khoavx.accessoriceshop.Utils.Common;
import com.example.khoavx.accessoriceshop.Utils.Config;
import com.example.khoavx.accessoriceshop.Utils.RecyclerItemTouchHelper;
import com.example.khoavx.accessoriceshop.Utils.RecyclerItemTouchHelperListenner;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.google.gson.Gson;
import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.TextHttpResponseHandler;
import com.paypal.android.sdk.payments.PayPalConfiguration;
import com.paypal.android.sdk.payments.PayPalPayment;
import com.paypal.android.sdk.payments.PayPalService;
import com.paypal.android.sdk.payments.PaymentActivity;
import com.paypal.android.sdk.payments.PaymentConfirmation;

import org.json.JSONObject;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import cz.msebera.android.httpclient.Header;
import dmax.dialog.SpotsDialog;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class CartActivity extends AppCompatActivity implements RecyclerItemTouchHelperListenner {
    public static final int PAYMENT_REQUEST_CODE = 7777;

    @BindView(R.id.btn_back)
    ButtonBarLayout btn_back;
    @BindView(R.id.rv_cart)
    RecyclerView rv_cart;
    @BindView(R.id.btn_place_order)
    Button btn_place_order;
    @BindView(R.id.rootLayout)
    RelativeLayout rootLayout;
    CartAdapter cartAdapter;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    List<Cart> localCart = new ArrayList<>();
    ICallShopAPI iCallShopAPI;
    public String id;
    public int index;

    //Global String
    String token, amount, orderAddress, orderComment;
    HashMap<String, String> params;

    static PayPalConfiguration configuration = new PayPalConfiguration()
            .environment(PayPalConfiguration.ENVIRONMENT_SANDBOX)
            .clientId(Config.KEY_CLIENT_PAYPAL_ID);

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cart);
        ButterKnife.bind(this);

        iCallShopAPI = Common.callAPI();

        Intent i = new Intent(this, PayPalService.class);
        i.putExtra(PayPalService.EXTRA_PAYPAL_CONFIGURATION, configuration);
        startService(i);


        FirebaseDatabase database = FirebaseDatabase.getInstance();
        DatabaseReference myRef = database.getReference("order");
        myRef.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                id = String.valueOf(dataSnapshot.getChildrenCount() + 1);
            }

            @Override
            public void onCancelled(DatabaseError databaseError) {
                Log.d("BUG", databaseError.getMessage());
            }
        });

        rv_cart.setLayoutManager(new LinearLayoutManager(this));
        rv_cart.setHasFixedSize(true);
        ItemTouchHelper.SimpleCallback simpleCallback = new RecyclerItemTouchHelper(0, ItemTouchHelper.LEFT, this);
        new ItemTouchHelper(simpleCallback).attachToRecyclerView(rv_cart);
        loadCartItem();
        loadToken();


        btn_place_order.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                placaOrder();
            }
        });

        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

    }

    private void loadToken() {
        android.app.AlertDialog alertDialog = new SpotsDialog.Builder().setContext(CartActivity.this).build();
        alertDialog.show();
        alertDialog.setMessage("Plaese wating ...");
        AsyncHttpClient client = new AsyncHttpClient();
        client.get(Common.API_TOKEN_URL, new TextHttpResponseHandler() {
            @Override
            public void onFailure(int statusCode, Header[] headers, String responseString, Throwable throwable) {
                alertDialog.dismiss();
                btn_place_order.setEnabled(false);
                Toast.makeText(CartActivity.this, throwable.getMessage(), Toast.LENGTH_SHORT).show();
            }

            @Override
            public void onSuccess(int statusCode, Header[] headers, String responseString) {
                alertDialog.dismiss();
                token = responseString;
                btn_place_order.setEnabled(true);
            }
        });
    }

    private void placaOrder() {
        if (Common.currentCustomer != null) {
            final AlertDialog.Builder builder = new AlertDialog.Builder(CartActivity.this);
            builder.setTitle("Submit Order");
            LayoutInflater inflater = this.getLayoutInflater();
            View submit_order = inflater.inflate(R.layout.order_new_dialog, null);


            EditText edt_comment = (EditText) submit_order.findViewById(R.id.ed_comment);
            EditText edt_order_add = (EditText) submit_order.findViewById(R.id.ed_order_address);
            RadioButton rdo_user_address = (RadioButton) submit_order.findViewById(R.id.rdo_user_address);
            RadioButton rdo_order_address = (RadioButton) submit_order.findViewById(R.id.rdo_order_address);
            RadioButton rdo_payment1 = (RadioButton) submit_order.findViewById(R.id.rdo_payment_1);
            RadioButton rdo_payment2 = (RadioButton) submit_order.findViewById(R.id.rdo_payment_2);

            rdo_payment1.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
                @Override
                public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                    if (isChecked) {
                        index = 0;
                    }
                }
            });

            rdo_payment2.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
                @Override
                public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                    if (isChecked) {
                        index = 1;
                    }
                }
            });

            rdo_user_address.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
                @Override
                public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                    if (isChecked) {
                        edt_order_add.setEnabled(false);
                    }
                }
            });
            rdo_order_address.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
                @Override
                public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                    if (isChecked) {
                        edt_order_add.setEnabled(true);
                    }
                }
            });
            builder.setNegativeButton("CANCEL", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    dialog.dismiss();
                }
            });
            builder.setPositiveButton("SUBMIT", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    if (index == 0) {
                        orderComment = edt_comment.getText().toString();
                        if (rdo_user_address.isChecked()) {
                            orderAddress = Common.currentCustomer.getAddress();
                        } else if (rdo_order_address.isChecked()) {
                            orderAddress = edt_order_add.getText().toString();
                        }
                        //submit order
                        compositeDisposable.add(Common.cartRepository.getCartItems()
                                .observeOn(AndroidSchedulers.mainThread())
                                .subscribeOn(Schedulers.io())
                                .subscribe(new Consumer<List<Cart>>() {
                                    @Override
                                    public void accept(List<Cart> carts) throws Exception {
                                        if (!TextUtils.isEmpty(orderAddress)) {
                                            if (carts.size() > 0) {
                                                String invoiceDetail = new Gson().toJson(carts);
                                                iCallShopAPI.newOrder(String.valueOf(Common.cartRepository.sumPrice()),
                                                        Common.currentCustomer.getFirst_name(), Common.currentCustomer.getId(),
                                                        orderAddress, Common.currentCustomer.getPhone(), "0",
                                                        "1", "1", "1", invoiceDetail)
                                                        .enqueue(new Callback<Invoice>() {
                                                            @Override
                                                            public void onResponse(@NonNull Call<Invoice> call, @NonNull Response<Invoice> response) {

                                                                Toast.makeText(CartActivity.this, "Order success", Toast.LENGTH_SHORT).show();

                                                                //Clear
                                                                Common.cartRepository.emptyCart();
                                                                finish();
                                                            }

                                                            @Override
                                                            public void onFailure(@NonNull Call<Invoice> call, @NonNull Throwable t) {

                                                            }
                                                        });
                                            }
                                        } else {
                                            Toast.makeText(CartActivity.this, "Order Address can't null", Toast.LENGTH_SHORT).show();
                                        }
                                    }
                                })
                        );
                    } else {
                        orderComment = edt_comment.getText().toString();
                        if (rdo_user_address.isChecked()) {
                            orderAddress = Common.currentUser.getAddress();
                        } else if (rdo_order_address.isChecked()) {
                            orderAddress = edt_order_add.getText().toString();
                        }
                        String amount1 = String.valueOf(Common.cartRepository.sumPrice());
                        PayPalPayment payPalPayment = new PayPalPayment(new BigDecimal(amount1),
                                "USD",
                                "Eat It App Order",
                                PayPalPayment.PAYMENT_INTENT_SALE);
                        Intent intent = new Intent(getApplicationContext(), PaymentActivity.class);
                        intent.putExtra(PayPalService.EXTRA_PAYPAL_CONFIGURATION, configuration);
                        intent.putExtra(PaymentActivity.EXTRA_PAYMENT, payPalPayment);
                        startActivityForResult(intent, PAYMENT_REQUEST_CODE);
                    }

                }
            });
            builder.setView(submit_order);
            builder.show();
        } else {
            AlertDialog.Builder builder = new AlertDialog.Builder(this);
            builder.setTitle("NOT LOGIN");
            builder.setMessage("Please login or resigter account!!!");
            builder.setNegativeButton("CANCEL", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    dialog.dismiss();
                }
            });
            builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    dialog.dismiss();
                    startActivity(new Intent(CartActivity.this, MainActivity.class));
                }
            });
            builder.show();
        }
    }


    private void loadCartItem() {
        compositeDisposable.add(Common.cartRepository.getCartItems()
                .observeOn(AndroidSchedulers.mainThread())
                .subscribeOn(Schedulers.io())
                .subscribe(new Consumer<List<Cart>>() {
                    @Override
                    public void accept(List<Cart> carts) throws Exception {
                        if (carts.size() != 0) {
                            btn_place_order.setEnabled(true);
                            displayCartItem(carts);
                        } else {
                            btn_place_order.setEnabled(false);
                        }
                    }
                })
        );
    }

    private void displayCartItem(List<Cart> carts) {
        localCart = carts;
        cartAdapter = new CartAdapter(this, carts);
        rv_cart.setAdapter(cartAdapter);
    }

    @Override
    protected void onDestroy() {
        compositeDisposable.clear();
        super.onDestroy();
    }

    @Override
    protected void onStop() {
        compositeDisposable.clear();
        super.onStop();
    }

    @Override
    public void onSwiped(RecyclerView.ViewHolder viewHolder, int direction, int position) {
        if (viewHolder instanceof CartAdapter.ViewHolder) {
            String name = localCart.get(viewHolder.getAdapterPosition()).name;
            final Cart deleteItem = localCart.get(viewHolder.getAdapterPosition());
            final int deleteIndex = viewHolder.getAdapterPosition();
            cartAdapter.removeItem(deleteIndex);

            Common.cartRepository.deleteCartItems(deleteItem);

            Snackbar snackbar = Snackbar.make(rootLayout, new StringBuilder(name).append("removed from Favorites liat").toString(),
                    Snackbar.LENGTH_LONG);
            snackbar.setAction("UNDO", new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    cartAdapter.restoreItem(deleteItem, deleteIndex);
                    Common.cartRepository.insertToCart(deleteItem);
                }
            });
            snackbar.setActionTextColor(Color.YELLOW);
            snackbar.show();
        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == PAYMENT_REQUEST_CODE) {
            if (resultCode == RESULT_OK) {
                PaymentConfirmation confirm =
                        data.getParcelableExtra(PaymentActivity.EXTRA_RESULT_CONFIRMATION);
                if (confirm != null) {
                    try {
                        String paymentdetail = confirm.toJSONObject().toString(4);
                        JSONObject jsonObject = new JSONObject(paymentdetail);
                        //submit order
                        compositeDisposable.add(Common.cartRepository.getCartItems()
                                        .observeOn(AndroidSchedulers.mainThread())
                                        .subscribeOn(Schedulers.io())
                                        .subscribe(new Consumer<List<Cart>>() {
                                            @Override
                                            public void accept(List<Cart> carts) throws Exception {
                                                if (!TextUtils.isEmpty(orderAddress)) {
                                            //sendOrderToServer(Common.cartRepository.sumPrice(), carts, orderComment, orderAddress,
                                            //        jsonObject.getJSONObject("response").getString("state"));
                                                } else {
                                                    Toast.makeText(CartActivity.this, "Order Address can't null", Toast.LENGTH_SHORT).show();
                                                }
                                            }
                                        })
                        );

                    } catch (Exception e) {
                        Log.d("EMDT_ERROR", e.getMessage());
                    }
                } else {
                    Toast.makeText(CartActivity.this, "Payment amount is 0", Toast.LENGTH_SHORT).show();
                }
            } else if (resultCode == RESULT_CANCELED) {
                // canceled
                Toast.makeText(this, "Payment cancelled", Toast.LENGTH_SHORT).show();
            } else {
                // an error occurred, checked the returned exception
                Exception exception = (Exception) data.getSerializableExtra(DropInActivity.EXTRA_ERROR);
                Log.d("EMDT_ERROR", exception.getMessage());
            }
        }
    }
}
