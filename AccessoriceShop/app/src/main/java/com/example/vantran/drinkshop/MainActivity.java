package com.example.vantran.drinkshop;

import android.Manifest;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.ButtonBarLayout;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TabHost;
import android.widget.Toast;


import com.example.vantran.drinkshop.Model.CheckUserResponse;
import com.example.vantran.drinkshop.Model.Customer;
import com.example.vantran.drinkshop.Model.Token;
import com.example.vantran.drinkshop.Model.User;
import com.example.vantran.drinkshop.Retrofit.ICallShopAPI;
import com.example.vantran.drinkshop.Retrofit.IDrinkShopAPI;
import com.example.vantran.drinkshop.Utils.Common;
import com.facebook.accountkit.Account;
import com.facebook.accountkit.AccountKit;
import com.facebook.accountkit.AccountKitCallback;
import com.facebook.accountkit.AccountKitError;
import com.facebook.accountkit.AccountKitLoginResult;
import com.facebook.accountkit.ui.AccountKitActivity;
import com.facebook.accountkit.ui.AccountKitConfiguration;
import com.facebook.accountkit.ui.LoginType;
import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.InstanceIdResult;
import com.rengwuxian.materialedittext.MaterialEditText;


import java.util.ArrayList;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import dmax.dialog.SpotsDialog;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {

    public static int APP_REQUEST_CODE = 1000;
    public static final int REQUEST_PERMISION = 1001;
    IDrinkShopAPI iDrinkShopAPI;
    ICallShopAPI iCallShopAPI;
    @BindView(R.id.btn_continue)
    ImageView btn_contiune;
    @BindView(R.id.tabHost)
    TabHost host;
    @BindView(R.id.btn_sigin)
    Button btn_sigin;
    @BindView(R.id.btn_sigup)
    Button btn_sigup;
    @BindView(R.id.edt_username)
    EditText edt_username;
    @BindView(R.id.edt_password)
    EditText edt_password;
    @BindView(R.id.edt_email_up)
    EditText edt_email_up;
    @BindView(R.id.edt_user_up)
    EditText edt_user_up;
    @BindView(R.id.edt_password_up)
    EditText edt_password_up;
    @BindView(R.id.edt_password_confirm)
    EditText edt_password_confirm;
    @BindView(R.id.btn_back)
    ButtonBarLayout btn_back;

    TabHost tabHost;

    String UserName;
    String PassWord;
    String Email;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        ButterKnife.bind(this);
        iDrinkShopAPI = Common.getAPI();
        iCallShopAPI = Common.callAPI();


        host.setup();

        //Tab 1
        TabHost.TabSpec spec = host.newTabSpec("Sign In");
        spec.setContent(R.id.tab1);
        spec.setIndicator("Sign In");
        host.addTab(spec);

        //Tab 2
        spec = host.newTabSpec("Sign Up");
        spec.setContent(R.id.tab2);
        spec.setIndicator("Sign Up");
        host.addTab(spec);
        host.getTabWidget().getChildAt(host.getCurrentTab())
                .setBackgroundColor(Color.parseColor("#458edb")); // selected

        host.setOnTabChangedListener(new TabHost.OnTabChangeListener() {
            @Override
            public void onTabChanged(String tabId) {
                for (int i = 0; i < host.getTabWidget().getChildCount(); i++) {
                    host.getTabWidget().getChildAt(i)
                            .setBackgroundColor(Color.parseColor("#ffffff")); // unselected
                }
                host.getTabWidget().getChildAt(host.getCurrentTab())
                        .setBackgroundColor(Color.parseColor("#458edb")); // selected
            }
        });

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.READ_EXTERNAL_STORAGE)
                != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{
                    Manifest.permission.READ_EXTERNAL_STORAGE
            }, REQUEST_PERMISION);
        }

        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        btn_sigin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (TextUtils.isEmpty(edt_username.getText().toString()) || TextUtils.isEmpty(edt_password.getText().toString())) {
                    if (TextUtils.isEmpty(edt_username.getText().toString())) {
                        edt_username.setError("Please enter Username");
                    }
                    if (TextUtils.isEmpty(edt_password.getText().toString())) {
                        edt_password.setError("Please enter Password");
                    }
                } else {
                    doLogin(edt_username.getText().toString(), edt_password.getText().toString());
                }
            }
        });

        btn_sigup.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (TextUtils.isEmpty(edt_user_up.getText().toString()) || TextUtils.isEmpty(edt_password_up.getText().toString())
                        || TextUtils.isEmpty(edt_user_up.getText().toString()) || TextUtils.isEmpty(edt_password_confirm.getText().toString())) {
                    if (TextUtils.isEmpty(edt_email_up.getText().toString())) {
                        edt_user_up.setError("Please enter Username");
                    }
                    if (TextUtils.isEmpty(edt_password_up.getText().toString())) {
                        edt_password_up.setError("Please enter Password");
                    }
                    if (TextUtils.isEmpty(edt_email_up.getText().toString())) {
                        edt_email_up.setError("Please enter Email");
                    }
                    if (TextUtils.isEmpty(edt_password_confirm.getText().toString())) {
                        edt_password_confirm.setError("Please enter Password Confirm");
                    }
                } else if (!edt_password_up.getText().toString().equals(edt_password_confirm.getText().toString())) {
                    edt_password_confirm.setError("Password Confirm wrong");
                } else {
                    doCheck(edt_email_up.getText().toString(), edt_user_up.getText().toString(), edt_password_up.getText().toString());
                }
            }
        });

        btn_contiune.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startLoginFB(LoginType.PHONE);

            }
        });

    }

    private void doCheck(String email, String username, String password) {

        AlertDialog alertDialog = new SpotsDialog.Builder().setContext(MainActivity.this).build();
        alertDialog.show();
        alertDialog.setMessage("Plaese wating ...");
        iCallShopAPI.checkUserExits(username, email)
                .enqueue(new Callback<CheckUserResponse>() {
                    @Override
                    public void onResponse(Call<CheckUserResponse> call, Response<CheckUserResponse> response) {
                        CheckUserResponse userResponse = response.body();
                        if (userResponse.isExists()) {
                            alertDialog.dismiss();
                            Toast.makeText(MainActivity.this, "Username or email exist", Toast.LENGTH_SHORT).show();
                        } else {
                            UserName = username;
                            PassWord = password;
                            Email = email;
                            startLoginFB(LoginType.PHONE);
                        }
                    }

                    @Override
                    public void onFailure(Call<CheckUserResponse> call, Throwable t) {

                    }
                });
    }

    private void doRegister(String email, String username, String password, String phone) {
        final AlertDialog watingDialog = new SpotsDialog.Builder().setContext(MainActivity.this).build();
        watingDialog.show();
        watingDialog.setMessage("Plaese wating ...");

        iCallShopAPI.register(username, password, email, phone)
                .enqueue(new Callback<Customer>() {
                    @Override
                    public void onResponse(Call<Customer> call, Response<Customer> response) {
                        watingDialog.dismiss();
                        Customer customer = response.body();
                        Toast.makeText(MainActivity.this, "Register successfully", Toast.LENGTH_SHORT).show();
                        Common.currentCustomer = response.body();
                        startActivity(new Intent(MainActivity.this, HomeActivity.class));
                        finish();
                    }

                    @Override
                    public void onFailure(Call<Customer> call, Throwable t) {
                        watingDialog.dismiss();
                    }
                });
    }

    private void doLogin(String user_name, String passowrd) {
        final AlertDialog watingDialog = new SpotsDialog.Builder().setContext(MainActivity.this).build();
        watingDialog.show();
        watingDialog.setMessage("Plaese wating ...");

        iCallShopAPI.customer(user_name, passowrd)
                .enqueue(new Callback<Customer>() {
                    @Override
                    public void onResponse(Call<Customer> call, Response<Customer> response) {
                        watingDialog.dismiss();
                        Customer customer = response.body();
                        Toast.makeText(MainActivity.this, "Login successfully", Toast.LENGTH_SHORT).show();
                        Common.currentCustomer = response.body();
                        //update toke

                        startActivity(new Intent(MainActivity.this, HomeActivity.class));
                        finish();
                    }

                    @Override
                    public void onFailure(Call<Customer> call, Throwable t) {
                        watingDialog.dismiss();
                    }
                });
    }

    private void startLoginFB(LoginType phone) {
        Intent intent = new Intent(this, AccountKitActivity.class);
        AccountKitConfiguration.AccountKitConfigurationBuilder configurationBuilder =
                new AccountKitConfiguration.AccountKitConfigurationBuilder(
                        phone,
                        AccountKitActivity.ResponseType.TOKEN);
        intent.putExtra(AccountKitActivity.ACCOUNT_KIT_ACTIVITY_CONFIGURATION,
                configurationBuilder.build());
        startActivityForResult(intent, APP_REQUEST_CODE);
    }


    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == APP_REQUEST_CODE) {
            AccountKitLoginResult loginResult = data.getParcelableExtra(AccountKitLoginResult.RESULT_KEY);
            if (loginResult.getError() != null) {
                Toast.makeText(this, "" + loginResult.getError().getErrorType().getMessage(), Toast.LENGTH_SHORT).show();
            } else if (loginResult.wasCancelled()) {
                Toast.makeText(this, "Cancel", Toast.LENGTH_SHORT).show();
            } else if (loginResult.getAccessToken() != null) {
                AlertDialog alertDialog = new SpotsDialog.Builder().setContext(MainActivity.this).build();
                alertDialog.show();
                alertDialog.setMessage("Please waiting ...");

                AccountKit.getCurrentAccount(new AccountKitCallback<Account>() {
                    @Override
                    public void onSuccess(final Account account) {
                        doRegister(Email, UserName, PassWord,account.getPhoneNumber().toString());
                        alertDialog.dismiss();
                    }

                    @Override
                    public void onError(AccountKitError accountKitError) {
                        Log.d("ERROR", accountKitError.getErrorType().getMessage());
                    }
                });
            }
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        switch (requestCode) {
            case REQUEST_PERMISION: {
                if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                    Toast.makeText(this, "Permission granted", Toast.LENGTH_SHORT).show();
                } else {
                    Toast.makeText(this, "Permission denied", Toast.LENGTH_SHORT).show();
                }
            }
        }
    }

    boolean isBackButtonClicked = false;

    @Override
    public void onBackPressed() {
        if (isBackButtonClicked) {
            super.onBackPressed();
            return;
        }
        this.isBackButtonClicked = true;
        Toast.makeText(this, "Please click Back again to exit", Toast.LENGTH_SHORT).show();
    }

    @Override
    protected void onResume() {
        isBackButtonClicked = false;
        super.onResume();
    }


    private void InsertUserFb(String phone, String name, String date, String address) {
        FirebaseDatabase database = FirebaseDatabase.getInstance();
        DatabaseReference myRef = database.getReference("user");
        String key = myRef.push().getKey();
        User user1 = new User();
        user1.setName(name);
        user1.setPhone(phone);
        user1.setAddress(address);
        user1.setBirthdate(date);
        user1.setKey(key);
        myRef.child(key).setValue(user1, new DatabaseReference.CompletionListener() {
            @Override
            public void onComplete(DatabaseError databaseError, DatabaseReference databaseReference) {
                if (databaseError == null) {
                    Toast.makeText(MainActivity.this, "User register successfully", Toast.LENGTH_SHORT).show();

                    startActivity(new Intent(MainActivity.this, HomeActivity.class));
                    finish();
                    Log.d("AA", "Resigter Success");
                } else {
                    Log.d("AA", "Resigter Failed");
                }
            }
        });

    }


}
