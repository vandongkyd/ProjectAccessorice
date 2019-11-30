package com.example.vantran.drinkshop.Apdater;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.vantran.drinkshop.Model.Brand;
import com.example.vantran.drinkshop.R;
import com.example.vantran.drinkshop.Utils.Common;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;

/**
 * Created by vandongluong on 7/31/18.
 */
public class BrandAdapter extends RecyclerView.Adapter<BrandAdapter.ViewHolder> {


    Context context;
    List<Brand> brands;

    private OnItemClickListener onItemClickListener;

    public BrandAdapter(Context context, List<Brand> categories) {
        this.context = context;
        this.brands = categories;
    }

    public interface OnItemClickListener {
        void onItemClicked(Brand category);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_menu_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        Brand category = brands.get(position);
        Picasso.with(context).load(Common.BASE_URL_IMAGE_API + category.getBrand_img()).into(holder.img_menu);

        holder.t_name_menu.setText(category.getBrand_name());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onItemClickListener(category);
            }
        });
    }

    @Override
    public int getItemCount() {
        return brands.size();
    }


    public void onItemClickListener(Brand category) {
        if (BrandAdapter.this.onItemClickListener != null) {
            BrandAdapter.this.onItemClickListener.onItemClicked(category);
        }
    }

    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public class ViewHolder extends RecyclerView.ViewHolder{

        @BindView(R.id.img_menu)
        ImageView img_menu;
        @BindView(R.id.t_name_menu)
        TextView t_name_menu;

        public ViewHolder(View view) {
            super(view);
            ButterKnife.bind(this, view);
        }
    }
}