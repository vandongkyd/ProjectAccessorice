package com.example.khoavx.accessoriceshop.Apdater;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.DialogInterface;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.cepheuen.elegantnumberbutton.view.ElegantNumberButton;
import com.example.khoavx.accessoriceshop.Database.ModelDB.Cart;
import com.example.khoavx.accessoriceshop.Database.ModelDB.Favorite;
import com.example.khoavx.accessoriceshop.Model.Product;
import com.example.khoavx.accessoriceshop.R;
import com.example.khoavx.accessoriceshop.Utils.Common;
import com.google.gson.Gson;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;

public class ProductAdapter extends RecyclerView.Adapter<ProductAdapter.ViewHolder> implements Filterable {


    private Context context;
    private List<Product> drinks;
    private List<Product> drinksearch;
    private OnItemClickListener onItemClickListener;

    public ProductAdapter(Context context, List<Product> drinks) {
        this.context = context;
        this.drinks = drinks;
        this.drinksearch = drinks;
    }

    public interface OnItemClickListener {
        void onItemClicked(Product drink);
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_drink_item, parent, false);
        return new ViewHolder(view);
    }

    @SuppressLint("SetTextI18n")
    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        Product drink = drinksearch.get(position);
        Picasso.with(context).load(Common.BASE_URL_IMAGE_API + drink.getFile_name()).into(holder.img_drink);
        double price = 0;
        Toast.makeText(context, drink.getPercent_reduction()+"", Toast.LENGTH_SHORT).show();
//        if (Integer.parseInt(drink.getPercent_reduction()) > 0){
//            holder.tv_discount.setText("-" + drink.getPercent_reduction() + "%");
//            price = (Double.parseDouble(drink.getProduct_price()) - (Double.parseDouble(drink.getProduct_price()) * Double.parseDouble(drink.getPercent_reduction())) / 100);
//        }else {
            holder.tv_discount.setVisibility(View.INVISIBLE);
            price = Double.parseDouble(drink.getProduct_price());
//        }
        holder.t_price.setText(Common.formatNumber(price) + " VND");
        holder.t_name_drink.setText(drink.getProduct_name());

        holder.btn_cart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showDialogAddToCart(drink);
            }
        });
        // set Favorite

        if (Common.favoriteRepository.isFavoriteItems(Integer.parseInt(drink.getId())) == 1) {
            holder.btn_like.setImageResource(R.drawable.ic_favorite_white);
        } else {
            holder.btn_like.setImageResource(R.drawable.ic_favorite_border_white);
        }

        holder.btn_like.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (Common.currentCustomer != null) {
                    if (Common.favoriteRepository.isFavoriteItems(Integer.parseInt(drink.getId())) != 1) {
                        addOrRemoveToFavorite(drink, true);
                        holder.btn_like.setImageResource(R.drawable.ic_favorite_white);
                    } else {
                        addOrRemoveToFavorite(drink, false);
                        holder.btn_like.setImageResource(R.drawable.ic_favorite_border_white);
                    }
                } else {
                    Common.PopupMessages("Like", (AppCompatActivity) context);
                }
            }
        });
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onItemClickListener(drink);
            }
        });
    }

    private void addOrRemoveToFavorite(Product drink, boolean isFavorite) {
        if (Common.currentCustomer != null) {
            Favorite favorite = new Favorite();
            favorite.id = Integer.parseInt(drink.getId());
            favorite.images = drink.getFile_name();
            favorite.name = drink.getProduct_name();
            favorite.price = Double.parseDouble(drink.getProduct_price());
            favorite.productId = Integer.parseInt(drink.getId());
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
        return drinksearch.size();
    }

    private void onItemClickListener(Product drink) {
        if (ProductAdapter.this.onItemClickListener != null) {
            ProductAdapter.this.onItemClickListener.onItemClicked(drink);
        }
    }

    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }


    @Override
    public Filter getFilter() {
        return new Filter() {
            @Override
            protected FilterResults performFiltering(CharSequence charSequence) {
                String charString = charSequence.toString();
                if (charString.isEmpty()) {
                    drinksearch = drinks;
                } else {
                    List<Product> filteredList = new ArrayList<>();
                    for (Product row : drinks) {

                        // name match condition. this might differ depending on your requirement
                        // here we are looking for name or phone number match
                        if (row.getProduct_name().toLowerCase().contains(charString.toLowerCase())) {
                            filteredList.add(row);
                        }
                    }

                    drinksearch = filteredList;
                }

                FilterResults filterResults = new FilterResults();
                filterResults.values = drinksearch;
                return filterResults;
            }

            @Override
            protected void publishResults(CharSequence charSequence, FilterResults filterResults) {
                drinksearch = (List<Product>) filterResults.values;
                notifyDataSetChanged();
            }
        };
    }


    public static class ViewHolder extends RecyclerView.ViewHolder {

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
        @BindView(R.id.tv_discount)
        TextView tv_discount;

        public ViewHolder(View view) {
            super(view);
            ButterKnife.bind(this, view);
        }
    }


    private void showDialogAddToCart(Product drink) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        View itemView = LayoutInflater.from(context).inflate(R.layout.add_to_cart_layout, null);


        ImageView img_cart = (ImageView) itemView.findViewById(R.id.img_cart);
        ElegantNumberButton btn_number = (ElegantNumberButton) itemView.findViewById(R.id.t_count);
        TextView t_name_cart = (TextView) itemView.findViewById(R.id.t_name_cart);

        Picasso.with(context).load(Common.BASE_URL_IMAGE_API + drink.getFile_name()).into(img_cart);
        t_name_cart.setText(drink.getProduct_name());

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

    @SuppressLint("SetTextI18n")
    private void showDialogConfrim(Product drink, String number) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        View itemView = LayoutInflater.from(context).inflate(R.layout.dialog_confrim_addcart, null);

        ImageView img_cart = (ImageView) itemView.findViewById(R.id.img_drink);
        TextView t_name_cart = (TextView) itemView.findViewById(R.id.t_name_cart);
        TextView t_price = (TextView) itemView.findViewById(R.id.t_price);

        Picasso.with(context).load(Common.BASE_URL_IMAGE_API + drink.getFile_name()).into(img_cart);
        t_name_cart.setText(drink.getProduct_name() + "x" + number);
        double price = (Double.parseDouble(drink.getProduct_price()));

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
                    if (Common.currentCustomer != null) {
                        // Add to SQLite
                        // Create new Cart Item
                        Cart cartItem = new Cart();
                        cartItem.name = drink.getProduct_name();
                        cartItem.quality_item = Integer.parseInt(number);
                        cartItem.amount = finalPrice;
                        cartItem.product_id = drink.getId();
                        cartItem.images = drink.getFile_name();

                        //Add to DB
                        Common.cartRepository.insertToCart(cartItem);

                        Log.d("EDMT_DEBUG", new Gson().toJson(cartItem));

                        Toast.makeText(context, "Save item to cart success", Toast.LENGTH_SHORT).show();
                    } else {
                        Common.PopupMessages("Cart", (AppCompatActivity) context);
                    }
                } catch (Exception e) {
                    Toast.makeText(context, e.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }
        });
        builder.setView(itemView);
        builder.show();
    }
}