package com.example.khoavx.accessoriceshop;

import androidx.annotation.BinderThread;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.ButtonBarLayout;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.khoavx.accessoriceshop.Utils.Common;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.FirebaseException;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.PhoneAuthCredential;
import com.google.firebase.auth.PhoneAuthProvider;

import java.util.concurrent.TimeUnit;

import butterknife.BindView;
import butterknife.ButterKnife;
import dmax.dialog.SpotsDialog;

public class VerifyPhoneActivity extends AppCompatActivity {

    @BindView(R.id.btn_generate_otp)
    Button btnGenerateOTP;
    @BindView(R.id.et_phone_number)
    EditText etPhoneNumber;
    @BindView(R.id.btn_back)
    ButtonBarLayout btn_back;


    String phoneNumber;
    FirebaseAuth auth;
    PhoneAuthProvider.OnVerificationStateChangedCallbacks mCallback;
    android.app.AlertDialog watingDialog;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_verify_phone);
        ButterKnife.bind(this);

        StartFirebaseLogin();
        watingDialog = new SpotsDialog.Builder().setContext(VerifyPhoneActivity.this).build();

        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        btnGenerateOTP.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                watingDialog.show();
                watingDialog.setMessage("Plaese wating ...");
                phoneNumber=etPhoneNumber.getText().toString();
                PhoneAuthProvider.getInstance().verifyPhoneNumber(
                        phoneNumber,                     // Phone number to verify
                        60,                           // Timeout duration
                        TimeUnit.SECONDS,                // Unit of timeout
                        VerifyPhoneActivity.this,        // Activity (for callback binding)
                        mCallback);
            }
        });
    }

    private void StartFirebaseLogin() {
        auth = FirebaseAuth.getInstance();
        mCallback = new PhoneAuthProvider.OnVerificationStateChangedCallbacks() {
            @Override
            public void onVerificationCompleted(@NonNull PhoneAuthCredential phoneAuthCredential) {
                Toast.makeText(VerifyPhoneActivity.this,"verification completed",Toast.LENGTH_SHORT).show();
                watingDialog.dismiss();
            }
            @Override
            public void onVerificationFailed(@NonNull FirebaseException e) {
                Toast.makeText(VerifyPhoneActivity.this,"verification fialed",Toast.LENGTH_SHORT).show();
                watingDialog.dismiss();
            }
            @Override
            public void onCodeSent(@NonNull String s, @NonNull PhoneAuthProvider.ForceResendingToken forceResendingToken) {
                super.onCodeSent(s, forceResendingToken);
                Common.verificationCode = s;
                watingDialog.dismiss();
                startActivity(new Intent(VerifyPhoneActivity.this, VerifyActivity.class));
            }
        };
    }
}
