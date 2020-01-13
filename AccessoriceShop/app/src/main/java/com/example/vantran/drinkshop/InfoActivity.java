package com.example.vantran.drinkshop;

import android.app.AlertDialog;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.vantran.drinkshop.Model.Customer;
import com.example.vantran.drinkshop.Retrofit.ICallShopAPI;
import com.example.vantran.drinkshop.Utils.Common;

import butterknife.BindView;
import butterknife.ButterKnife;
import dmax.dialog.SpotsDialog;
import io.reactivex.disposables.CompositeDisposable;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class InfoActivity extends AppCompatActivity {

    @BindView(R.id.btn_update)
    Button btn_update;
    @BindView(R.id.edt_last_name)
    EditText edt_last_name;
    @BindView(R.id.edt_first_name)
    EditText edt_first_name;
    @BindView(R.id.edt_phone)
    EditText edt_phone;
    @BindView(R.id.edt_email)
    EditText edt_email;
    @BindView(R.id.edt_user)
    EditText edt_user;
    @BindView(R.id.edt_address)
    EditText edt_address;

    CompositeDisposable compositeDisposable = new CompositeDisposable();
    ICallShopAPI iCallShopAPI;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info);
        ButterKnife.bind(this);

        iCallShopAPI = Common.callAPI();
        Customer customer = Common.currentCustomer;
        edt_last_name.setText(customer.getLast_name());
        edt_first_name.setText(customer.getFirst_name());
        edt_phone.setText(customer.getPhone());
        edt_email.setText(customer.getEmail());
        edt_user.setText(customer.getUser_name());
        edt_address.setText(customer.getAddress());
        btn_update.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String lastname = edt_last_name.getText().toString();
                String firstname = edt_first_name.getText().toString();
                String address = edt_address.getText().toString();
                changeInfo(customer.getId(), lastname,firstname,address,"1");
            }
        });
    }

    private void changeInfo(String id,String lastName, String firstName, String address, String gender){
        final AlertDialog watingDialog = new SpotsDialog.Builder().setContext(InfoActivity.this).build();
        watingDialog.show();
        watingDialog.setMessage("Plaese wating ...");
        iCallShopAPI.changeinfo(id,firstName,lastName,address,gender)
                .enqueue(new Callback<Customer>() {
                    @Override
                    public void onResponse(Call<Customer> call, Response<Customer> response) {
                        watingDialog.dismiss();
                        Customer customer = response.body();
                        Toast.makeText(InfoActivity.this, "Update Info successfully", Toast.LENGTH_SHORT).show();
                        Common.currentCustomer = response.body();
                        finish();
                    }

                    @Override
                    public void onFailure(Call<Customer> call, Throwable t) {
                        watingDialog.dismiss();
                    }
        });
    }
}
