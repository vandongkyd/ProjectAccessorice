package com.example.khoavx.accessoriceshop.Apdater;

import android.content.Context;
import androidx.recyclerview.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.example.khoavx.accessoriceshop.Database.ModelDB.Favorite;
import com.example.khoavx.accessoriceshop.R;
import com.example.khoavx.accessoriceshop.Utils.Common;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;

/**
 * Created by vandongluong on 7/31/18.
 */
public class FavoriteAdapter extends RecyclerView.Adapter<FavoriteAdapter.ViewHolder> {


    Context context;
    List<Favorite> favorites;

    private OnItemClickListener onItemClickListener;

    public FavoriteAdapter(Context context, List<Favorite> favorites) {
        this.context = context;
        this.favorites = favorites;
    }

    public interface OnItemClickListener {
        void onItemClicked(Favorite favorite);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_favorite_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        Favorite favorite = favorites.get(position);
        Picasso.with(context).load(Common.BASE_URL_IMAGE_API + favorite.images).into(holder.img_cart);

        holder.t_name_cart.setText(favorite.name);
        holder.t_price.setText(new StringBuilder("$").append(favorite.price).toString());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onItemClickListener(favorite);
            }
        });
    }

    @Override
    public int getItemCount() {
        return favorites.size();
    }


    public void onItemClickListener(Favorite favorite) {
        if (FavoriteAdapter.this.onItemClickListener != null) {
            FavoriteAdapter.this.onItemClickListener.onItemClicked(favorite);
        }
    }

    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public void removeItem(int position){
        favorites.remove(position);
        notifyDataSetChanged();
    }

    public void restoreItem(Favorite favorite,int position){
        favorites.add(position,favorite);
        notifyItemInserted(position);
    }

    public class ViewHolder extends RecyclerView.ViewHolder{

        @BindView(R.id.img_cart)
        ImageView img_cart;
        @BindView(R.id.t_name_cart)
        TextView t_name_cart;
        @BindView(R.id.t_price)
        TextView t_price;
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