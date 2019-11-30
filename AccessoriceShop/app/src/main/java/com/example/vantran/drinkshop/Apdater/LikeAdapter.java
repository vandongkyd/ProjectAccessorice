package com.example.vantran.drinkshop.Apdater;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.cepheuen.elegantnumberbutton.view.ElegantNumberButton;
import com.example.vantran.drinkshop.Database.ModelDB.Cart;
import com.example.vantran.drinkshop.Database.ModelDB.Favorite;
import com.example.vantran.drinkshop.Model.Category;
import com.example.vantran.drinkshop.Model.Drink;
import com.example.vantran.drinkshop.R;
import com.example.vantran.drinkshop.Utils.Common;
import com.google.gson.Gson;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;

public class LikeAdapter extends RecyclerView.Adapter<LikeAdapter.ViewHolder> {


    Context context;
    List<Favorite> favorites;
    private LikeAdapter.OnItemClickListener onItemClickListener;

    public LikeAdapter(Context context, List<Favorite> favorites) {
        this.context = context;
        this.favorites = favorites;
    }

    public interface OnItemClickListener {
        void onItemClicked(Category category);
    }

    @Override
    public LikeAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_drink_item, parent, false);
        return new LikeAdapter.ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(LikeAdapter.ViewHolder holder, int position) {
        if (Common.currentCustomer != null) {
            Favorite drink = favorites.get(position);
            if (drink.phone.equals(Common.currentCustomer.getPhone())) {
                Picasso.with(context).load(Common.BASE_URL_IMAGE_API + drink.images).into(holder.img_drink);

                holder.t_price.setText(new StringBuilder("$").append(drink.price));
                holder.t_name_drink.setText(drink.name);

                holder.btn_cart.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        showDialogAddToCart(drink);
                    }
                });
                // set Favorite

                if (Common.favoriteRepository.isFavoriteItems(Integer.valueOf(drink.id)) == 1) {
                    holder.btn_like.setImageResource(R.drawable.ic_favorite_white);
                } else {
                    holder.btn_like.setImageResource(R.drawable.ic_favorite_border_white);
                }

                holder.btn_like.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        if (Common.favoriteRepository.isFavoriteItems(Integer.valueOf(drink.id)) != 1) {
                            addOrRemoveToFavorite(drink, true);
                            holder.btn_like.setImageResource(R.drawable.ic_favorite_white);
                        } else {
                            addOrRemoveToFavorite(drink, false);
                            holder.btn_like.setImageResource(R.drawable.ic_favorite_border_white);
                        }
                    }
                });
            }
        }
    }

    private void addOrRemoveToFavorite(Favorite drink, boolean isFavorite) {

        if (Common.currentCustomer != null) {
            Favorite favorite = new Favorite();
            favorite.id = Integer.valueOf(drink.id);
            favorite.images = drink.images;
            favorite.name = drink.name;
            favorite.price = Double.valueOf(drink.price);
            favorite.productId = Integer.valueOf(drink.productId);
            favorite.phone = Common.currentCustomer.getPhone();
            if (isFavorite) {
                Common.favoriteRepository.insertToFavorite(favorite);
            } else {
                Common.favoriteRepository.deleteFavoriteItems(favorite);
            }
        }
    }


    @Override
    public int getItemCount() {
        return favorites.size();
    }


    public void setOnItemClickListener(LikeAdapter.OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public class ViewHolder extends RecyclerView.ViewHolder {

        @BindView(R.id.img_drink)
        ImageView img_drink;
        @BindView(R.id.t_name_drink)
        TextView t_name_drink;
        @BindView(R.id.t_price)
        TextView t_price;
        @BindView(R.id.btn_cart)
        ImageView btn_cart;
        @BindView(R.id.btn_like)
        ImageView btn_like;

        public ViewHolder(View view) {
            super(view);
            ButterKnife.bind(this, view);
        }
    }


    private void showDialogAddToCart(Favorite drink) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        View itemView = LayoutInflater.from(context).inflate(R.layout.add_to_cart_layout, null);


        ImageView img_cart = (ImageView) itemView.findViewById(R.id.img_cart);
        ElegantNumberButton btn_number = (ElegantNumberButton) itemView.findViewById(R.id.t_count);
        TextView t_name_cart = (TextView) itemView.findViewById(R.id.t_name_cart);

        Picasso.with(context).load(Common.BASE_URL_IMAGE_API + drink.images).into(img_cart);
        t_name_cart.setText(drink.name);

        builder.setView(itemView);
        builder.setPositiveButton("CANCEL", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.cancel();
            }
        });
        builder.setNegativeButton("ADD TO CART", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                showDialogConfrim(drink, btn_number.getNumber());
                dialog.dismiss();
            }
        });
        builder.show();


    }

    private void showDialogConfrim(Favorite drink, String number) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        View itemView = LayoutInflater.from(context).inflate(R.layout.dialog_confrim_addcart, null);

        ImageView img_cart = (ImageView) itemView.findViewById(R.id.img_drink);
        TextView t_name_cart = (TextView) itemView.findViewById(R.id.t_name_cart);
        TextView t_price = (TextView) itemView.findViewById(R.id.t_price);

        Picasso.with(context).load(Common.BASE_URL_IMAGE_API + drink.images).into(img_cart);
        t_name_cart.setText(new StringBuilder(drink.name).append("x")
                .append(number).toString()

        );
        double price = (Double.valueOf(drink.price) * Double.valueOf(number) + Common.toppingPrice);

        double finalPrice = Math.round(price);
        t_price.setText(new StringBuilder("$").append(finalPrice));
        builder.setPositiveButton("CANCEL", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });
        builder.setNegativeButton("CONFIRM", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
                try {
                    // Add to SQLite
                    // Create new Cart Item
                    Cart cartItem = new Cart();
                    cartItem.name = drink.name;
                    cartItem.amount = finalPrice;
                    cartItem.product_id = String.valueOf(drink.productId);
                    cartItem.quality_item = Integer.valueOf(number);
                    cartItem.images = drink.images;

                    //Add to DB
                    Common.cartRepository.insertToCart(cartItem);

                    Log.d("EDMT_DEBUG", new Gson().toJson(cartItem));

                    Toast.makeText(context, "Save item to cart success", Toast.LENGTH_SHORT).show();

                } catch (Exception e) {
                    Toast.makeText(context, e.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }
        });
        builder.setView(itemView);
        builder.show();
    }
}