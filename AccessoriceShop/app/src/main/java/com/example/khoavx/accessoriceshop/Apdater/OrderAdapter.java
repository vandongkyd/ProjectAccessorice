package com.example.khoavx.accessoriceshop.Apdater;

import android.content.Context;
import androidx.recyclerview.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.khoavx.accessoriceshop.Model.Invoice;
import com.example.khoavx.accessoriceshop.R;
import com.example.khoavx.accessoriceshop.Utils.Common;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;

/**
 * Created by vandongluong on 7/31/18.
 */
public class OrderAdapter extends RecyclerView.Adapter<OrderAdapter.ViewHolder> {


    Context context;
    List<Invoice> orders;
    private OnItemClickListener onItemClickListener;

    public OrderAdapter(Context context, List<Invoice> orders) {
        this.context = context;
        this.orders = orders;
    }

    public interface OnItemClickListener {
        void onItemClicked(Invoice order);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_yourorder_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        Invoice order = orders.get(position);

        holder.t_order_date.setText(Common.getDateFormat(order.getCreated()));
        holder.t_price.setText(Common.formatNumber(Double.parseDouble(order.getTotal_amount())) + " VND");
        holder.t_order_id.setText(new StringBuilder("#").append(order.getInvoice_no()).toString());
        holder.t_order_comemt.setText(new StringBuilder("Recipient: ").append(order.getRecipient_name()).toString());
        holder.t_order_address.setText(new StringBuilder("Address: ").append(order.getAddress()).toString());
        holder.t_order_status.setText(new StringBuilder("Status: ").append(Common.convertCodeToStatus(Integer.parseInt(order.getInvoice_status())).toString()));
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onItemClickListener(order);
            }
        });

    }


    @Override
    public int getItemCount() {
        return orders.size();
    }

    public void onItemClickListener(Invoice drink) {
        if (OrderAdapter.this.onItemClickListener != null) {
            OrderAdapter.this.onItemClickListener.onItemClicked(drink);
        }
    }

    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public class ViewHolder extends RecyclerView.ViewHolder {

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

        public ViewHolder(View view) {
            super(view);
            ButterKnife.bind(this, view);
        }
    }

}