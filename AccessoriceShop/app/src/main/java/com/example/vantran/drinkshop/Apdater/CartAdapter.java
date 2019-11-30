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
import com.example.vantran.drinkshop.R;
import com.example.vantran.drinkshop.Utils.Common;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;

/**
 * Created by vandongluong on 7/31/18.
 */
public class CartAdapter extends RecyclerView.Adapter<CartAdapter.ViewHolder> {


    Context context;
    List<Cart> carts;

    private OnItemClickListener onItemClickListener;

    public CartAdapter(Context context, List<Cart> carts) {
        this.context = context;
        this.carts = carts;
    }

    public interface OnItemClickListener {
        void onItemClicked(Drink drink);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_cart_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        Cart cart = carts.get(position);

        Picasso.with(context).load(Common.BASE_URL_IMAGE_API + cart.images).into(holder.img_cart);

        holder.t_count.setNumber(String.valueOf(cart.quality_item));
        holder.t_price.setText(new StringBuilder("$").append(cart.amount));
        holder.t_name_cart.setText(new StringBuilder(cart.name).append(" x").append(cart.quality_item));

        final double priceOneCup =  cart.amount / cart.quality_item;
        holder.t_count.setOnValueChangeListener(new ElegantNumberButton.OnValueChangeListener() {
            @Override
            public void onValueChange(ElegantNumberButton view, int oldValue, int newValue) {
                Cart cart1 = cart;
                cart1.quality_item = newValue;
                cart1.amount = Math.round(priceOneCup*newValue);
                Common.cartRepository.updateCart(cart1);

                holder.t_price.setText(new StringBuilder("$").append(cart.amount));
            }
        });
    }

    @Override
    public int getItemCount() {
        return carts.size();
    }


//    public void onItemClickListener(Category category) {
//        if (MulitChoiceAdapter.this.onItemClickListener != null) {
//            MulitChoiceAdapter.this.onItemClickListener.onItemClicked(category);
//        }
//    }

    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public void removeItem(int position){
        carts.remove(position);
        notifyDataSetChanged();
    }

    public void restoreItem(Cart cart, int position){
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