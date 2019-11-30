package com.example.vantran.drinkshop;

import android.app.AlertDialog;
import android.content.Intent;
import android.support.annotation.NonNull;
import android.support.design.widget.BottomNavigationView;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.ButtonBarLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.vantran.drinkshop.Apdater.OrderAdapter;
import com.example.vantran.drinkshop.Model.Banner;
import com.example.vantran.drinkshop.Model.Invoice;
import com.example.vantran.drinkshop.Model.Order;
import com.example.vantran.drinkshop.Retrofit.ICallShopAPI;
import com.example.vantran.drinkshop.Retrofit.IDrinkShopAPI;
import com.example.vantran.drinkshop.Utils.Common;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.shagi.materialdatepicker.date.DatePickerFragmentDialog;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;
import java.util.concurrent.TimeUnit;

import butterknife.BindView;
import butterknife.ButterKnife;
import dmax.dialog.SpotsDialog;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;

public class YourOrderActivity extends AppCompatActivity {

    @BindView(R.id.rv_yourorder)
    public RecyclerView rv_yourorder;
    @BindView(R.id.bottom_nav)
    public BottomNavigationView bottom_nav;
    @BindView(R.id.btn_back)
    ButtonBarLayout btn_back;
    public MenuItem menuItem1;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    IDrinkShopAPI iDrinkShopAPI;
    ICallShopAPI iCallShopAPI;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_your_order);
        ButterKnife.bind(this);

        iCallShopAPI = Common.callAPI();

        rv_yourorder.setLayoutManager(new LinearLayoutManager(this));
        rv_yourorder.setHasFixedSize(true);
        String timeStamp = String.valueOf(TimeUnit.MILLISECONDS.toSeconds(System.currentTimeMillis()));

//        tv_date_find.setText(Common.getDateFormat(timeStamp));


        bottom_nav.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem menuItem) {
                menuItem1 = menuItem;
                if (menuItem.getItemId() == R.id.od_new){
                    loadOrder("0");
                }else if (menuItem.getItemId() == R.id.od_cancel){
                    loadOrder("4");
                }else if (menuItem.getItemId() == R.id.od_processing){
                    loadOrder("1");
                }else if (menuItem.getItemId() == R.id.od_shipping){
                    loadOrder("2");
                }else if (menuItem.getItemId() == R.id.od_shipped){
                    loadOrder("3");
                }
                return true;
            }
        });
        loadOrder("0");

        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

    }

    private void loadOrder(String status) {
        if (Common.currentCustomer != null) {
            AlertDialog alertDialog = new SpotsDialog.Builder().setContext(YourOrderActivity.this).build();
            alertDialog.show();
            alertDialog.setMessage("Please waiting ...");
            compositeDisposable.add(iCallShopAPI.getInvoice(Common.currentCustomer.getId(), status)
                    .subscribeOn(Schedulers.io())
                    .observeOn(AndroidSchedulers.mainThread())
                    .subscribe(new Consumer<List<Invoice>>() {
                        @Override
                        public void accept(List<Invoice> banners) throws Exception {
                            alertDialog.dismiss();
                            displayOrder(banners);
                        }
                    })
            );

        }else {
            Toast.makeText(this, "Plaese loging again!", Toast.LENGTH_SHORT).show();
            finish();
        }
    }

    private void displayOrder(List<Invoice> orders) {
        OrderAdapter orderAdapter = new OrderAdapter(this,orders);
        orderAdapter.setOnItemClickListener(clickListener);
        rv_yourorder.setAdapter(orderAdapter);
    }

    private OrderAdapter.OnItemClickListener clickListener = new OrderAdapter.OnItemClickListener() {

        @Override
        public void onItemClicked(Invoice drink) {
            Common.currentInvoice = drink;
            startActivity(new Intent(YourOrderActivity.this, OrderDetailActivity.class));
        }
    };

    @Override
    protected void onResume() {
        super.onResume();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }

    @Override
    protected void onStop() {
        super.onStop();
    }
}
