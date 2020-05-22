package com.example.khoavx.accessoriceshop;

import android.Manifest;
import android.app.AlertDialog;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.os.Bundle;
import androidx.annotation.NonNull;
import androidx.core.app.ActivityCompat;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.ButtonBarLayout;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TabHost;
import android.widget.Toast;

import com.example.khoavx.accessoriceshop.Model.CheckUserResponse;
import com.example.khoavx.accessoriceshop.Model.Customer;
import com.example.khoavx.accessoriceshop.Model.User;
import com.example.khoavx.accessoriceshop.Retrofit.ICallShopAPI;
import com.example.khoavx.accessoriceshop.Utils.Common;
import com.facebook.accountkit.Account;
import com.facebook.accountkit.AccountKit;
import com.facebook.accountkit.AccountKitCallback;
import com.facebook.accountkit.AccountKitError;
import com.facebook.accountkit.AccountKitLoginResult;
import com.facebook.accountkit.ui.AccountKitActivity;
import com.facebook.accountkit.ui.AccountKitConfiguration;
import com.facebook.accountkit.ui.LoginType;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;

import butterknife.BindView;
import butterknife.ButterKnife;
import dmax.dialog.SpotsDialog;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {

    public static int APP_REQUEST_CODE = 1000;
    public static final int REQUEST_PERMISION = 1001;
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
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        ButterKnife.bind(this);
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
    }

    private void doCheck(String email, String username, String password) {
        android.app.AlertDialog alertDialog = new SpotsDialog.Builder().setContext(MainActivity.this).build();
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
                            Common.UserName = username;
                            Common.PassWord = password;
                            Common.Email = email;
                            startActivity(new Intent(MainActivity.this, VerifyPhoneActivity.class));
                        }
                    }

                    @Override
                    public void onFailure(Call<CheckUserResponse> call, Throwable t) {

                    }
                });
    }

    private void doLogin(String user_name, String passowrd) {
        final android.app.AlertDialog watingDialog = new SpotsDialog.Builder().setContext(MainActivity.this).build();
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

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == REQUEST_PERMISION) {
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                Toast.makeText(this, "Permission granted", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(this, "Permission denied", Toast.LENGTH_SHORT).show();
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
}
