package com.example.khoavx.accessoriceshop;

import android.app.AlertDialog;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.ButtonBarLayout;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.khoavx.accessoriceshop.Apdater.OrderDetailAdapter;
import com.example.khoavx.accessoriceshop.Model.Invoice;
import com.example.khoavx.accessoriceshop.Model.InvoiceDetail;
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
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class OrderDetailActivity extends AppCompatActivity {

    @BindView(R.id.t_order_id)
    TextView t_order_id;
    @BindView(R.id.t_price)
    TextView t_price;
    @BindView(R.id.t_order_address)
    TextView t_order_address;
    @BindView(R.id.t_order_comemt)
    TextView t_order_comemt;
    @BindView(R.id.t_order_status)
    TextView t_order_status;
    @BindView(R.id.t_order_date)
    TextView t_order_date;
    @BindView(R.id.rv_order_detail)
    RecyclerView rv_order_detail;
    @BindView(R.id.btn_cancel)
    Button btn_cancel;
    @BindView(R.id.btn_back)
    ButtonBarLayout btn_back;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    ICallShopAPI iCallShopAPI;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_detail);
        ButterKnife.bind(this);
        Invoice order = Common.currentInvoice;
        iCallShopAPI = Common.callAPI();
        t_order_date.setText(Common.getDateFormat(order.getCreated()));
        t_price.setText(Common.formatNumber(Double.parseDouble(order.getTotal_amount())) + " VND");
        t_order_id.setText(new StringBuilder("#").append(order.getInvoice_no()).toString());
        t_order_comemt.setText(order.getRecipient_name());
        t_order_address.setText(order.getAddress());
        t_order_status.setText(Common.convertCodeToStatus(Integer.valueOf(order.getInvoice_status())));
        rv_order_detail.setLayoutManager(new LinearLayoutManager(this));
        rv_order_detail.setHasFixedSize(true);
        loadDetail(Common.currentInvoice.getId());
        if (order.getInvoice_status().equals("3") || order.getInvoice_status().equals("2")){
            btn_cancel.setEnabled(false);
        }else if (order.getInvoice_status().equals("4")){
            btn_cancel.setVisibility(View.GONE);
        }


        btn_cancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                cancelOrder(Common.currentInvoice);
            }
        });
        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }

    private void cancelOrder(Invoice currentOrder) {
        iCallShopAPI.cancelOrder(currentOrder.getId())
                .enqueue(new Callback<String>() {
                    @Override
                    public void onResponse(Call<String> call, Response<String> response) {
                        Toast.makeText(OrderDetailActivity.this, "Order has been cancelled", Toast.LENGTH_SHORT).show();
                        finish();
                    }

                    @Override
                    public void onFailure(Call<String> call, Throwable t) {
                    }
                });
    }

    private void loadDetail(String invoiceId){
        AlertDialog alertDialog = new SpotsDialog.Builder().setContext(OrderDetailActivity.this).build();
        alertDialog.show();
        alertDialog.setMessage("Please waiting ...");
        compositeDisposable.add(iCallShopAPI.getInvoiceDetail(invoiceId)
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Consumer<List<InvoiceDetail>>() {
                    @Override
                    public void accept(List<InvoiceDetail> banners) throws Exception {
                        alertDialog.dismiss();
                        displayOrderDetail(banners);
                    }
                })
        );
    }

    private void displayOrderDetail(List<InvoiceDetail> orders) {
        OrderDetailAdapter orderDetailAdapter = new OrderDetailAdapter(this, orders);
        rv_order_detail.setAdapter(orderDetailAdapter);
    }

}
