package com.example.khoavx.accessoriceshop;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.ButtonBarLayout;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.khoavx.accessoriceshop.Model.Customer;
import com.example.khoavx.accessoriceshop.Retrofit.ICallShopAPI;
import com.example.khoavx.accessoriceshop.Utils.Common;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.auth.PhoneAuthCredential;
import com.google.firebase.auth.PhoneAuthProvider;

import butterknife.BindView;
import butterknife.ButterKnife;
import dmax.dialog.SpotsDialog;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class VerifyActivity extends AppCompatActivity {

    @BindView(R.id.et_otp)
    EditText etOTP;
    @BindView(R.id.btn_sign_in)
    Button btnSignIn;
    @BindView(R.id.btn_back)
    ButtonBarLayout btn_back;

    FirebaseAuth auth;
    ICallShopAPI iCallShopAPI;

    PhoneAuthProvider.OnVerificationStateChangedCallbacks mCallback;

    String otp;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_verify);
        ButterKnife.bind(this);
        iCallShopAPI = Common.callAPI();
        auth = FirebaseAuth.getInstance();

        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        btnSignIn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                otp = etOTP.getText().toString();
                PhoneAuthCredential credential = PhoneAuthProvider.getCredential(Common.verificationCode, otp);
                SignInWithPhone(credential);
            }
        });
    }

    private void SignInWithPhone(PhoneAuthCredential credential) {
        auth.signInWithCredential(credential)
                .addOnCompleteListener(new OnCompleteListener<AuthResult>() {
                    @Override
                    public void onComplete(@NonNull Task<AuthResult> task) {
                        if (task.isSuccessful()) {
                            FirebaseUser user= FirebaseAuth.getInstance().getCurrentUser();
                            doRegister(Common.Email,Common.UserName,Common.PassWord,user.getPhoneNumber());
                        } else {
                            Toast.makeText(VerifyActivity.this,"Incorrect OTP",Toast.LENGTH_SHORT).show();
                        }
                    }
                });
    }

    private void doRegister(String email, String username, String password, String phone) {
        final android.app.AlertDialog watingDialog = new SpotsDialog.Builder().setContext(VerifyActivity.this).build();
        watingDialog.show();
        watingDialog.setMessage("Plaese wating ...");

        iCallShopAPI.register(username, password, email, phone)
                .enqueue(new Callback<Customer>() {
                    @Override
                    public void onResponse(Call<Customer> call, Response<Customer> response) {
                        watingDialog.dismiss();
                        Customer customer = response.body();
                        Toast.makeText(VerifyActivity.this, "Register successfully", Toast.LENGTH_SHORT).show();
                        Common.currentCustomer = response.body();
                        startActivity(new Intent(VerifyActivity.this, HomeActivity.class));
                        finish();
                    }

                    @Override
                    public void onFailure(Call<Customer> call, Throwable t) {
                        watingDialog.dismiss();
                    }
                });
    }
}
