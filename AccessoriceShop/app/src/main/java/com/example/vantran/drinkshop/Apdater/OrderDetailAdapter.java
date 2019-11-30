package com.example.vantran.drinkshop.Apdater;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.cepheuen.elegantnumberbutton.view.ElegantNumberButton;
import com.example.vantran.drinkshop.Database.ModelDB.Cart;
import com.example.vantran.drinkshop.Model.Drink;
import com.example.vantran.drinkshop.Model.InvoiceDetail;
import com.example.vantran.drinkshop.R;
import com.example.vantran.drinkshop.Utils.Common;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;

/**
 * Created by vandongluong on 7/31/18.
 */
public class OrderDetailAdapter extends RecyclerView.Adapter<OrderDetailAdapter.ViewHolder> {


    Context context;
    List<InvoiceDetail> carts;

    private OnItemClickListener onItemClickListener;

    public OrderDetailAdapter(Context context, List<InvoiceDetail> carts) {
        this.context = context;
        this.carts = carts;
    }

    public interface OnItemClickListener {
        void onItemClicked(Drink drink);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_invoice_detail_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        InvoiceDetail cart = carts.get(position);

        Picasso.with(context).load(Common.BASE_URL_IMAGE_API + cart.getFile_name()).into(holder.img_cart);

        holder.t_count.setNumber(String.valueOf(cart.getQuality_item()));
        holder.t_price.setText(new StringBuilder("$").append(cart.getAmount()));
        holder.t_name_cart.setText(new StringBuilder(cart.getProduct_name()).append(" x").append(cart.getQuality_item()));


        holder.t_count.setVisibility(View.GONE);
        holder.tv_count.setVisibility(View.VISIBLE);
        holder.tv_count.setText(String.valueOf(cart.getQuality_item()));
    }

    @Override
    public int getItemCount() {
        return carts.size();
    }


    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public void removeItem(int position){
        carts.remove(position);
        notifyDataSetChanged();
    }

    public void restoreItem(InvoiceDetail cart, int position){
        carts.add(position,cart);
        notifyItemInserted(position);
    }


    public class ViewHolder extends RecyclerView.ViewHolder{

        @BindView(R.id.img_cart)
        ImageView img_cart;
        @BindView(R.id.t_price)
        TextView t_price;
        @BindView(R.id.t_sug_ice)
        TextView t_sug_ice;
        @BindView(R.id.t_count)
        ElegantNumberButton t_count;
        @BindView(R.id.tv_count)
        TextView tv_count;
        @BindView(R.id.t_name_cart)
        TextView t_name_cart;
        @BindView(R.id.view_backgroud)
        public RelativeLayout view_backgroud;
        @BindView(R.id.view_foreground)
        public LinearLayout view_foreground;

        public ViewHolder(View view) {
            super(view);
            ButterKnife.bind(this, view);
        }
    }
}