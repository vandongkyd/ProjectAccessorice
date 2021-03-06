package com.example.khoavx.accessoriceshop;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.ButtonBarLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import android.view.View;
import android.widget.Toast;

import com.example.khoavx.accessoriceshop.Apdater.OrderAdapter;
import com.example.khoavx.accessoriceshop.Model.Invoice;
import com.example.khoavx.accessoriceshop.Retrofit.ICallShopAPI;
import com.example.khoavx.accessoriceshop.Utils.Common;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import dmax.dialog.SpotsDialog;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;

public class HistoryActivity extends AppCompatActivity {


    @BindView(R.id.rv_yourorder)
    public RecyclerView rv_yourorder;
    @BindView(R.id.btn_back)
    ButtonBarLayout btn_back;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    ICallShopAPI iCallShopAPI;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_history);
        ButterKnife.bind(this);

        iCallShopAPI = Common.callAPI();

        rv_yourorder.setLayoutManager(new LinearLayoutManager(this));
        rv_yourorder.setHasFixedSize(true);

        loadOrder("3");

        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }

    private void loadOrder(String status) {
        if (Common.currentCustomer != null) {
            AlertDialog alertDialog = new SpotsDialog.Builder().setContext(HistoryActivity.this).build();
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
            startActivity(new Intent(HistoryActivity.this, OrderDetailActivity.class));
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
