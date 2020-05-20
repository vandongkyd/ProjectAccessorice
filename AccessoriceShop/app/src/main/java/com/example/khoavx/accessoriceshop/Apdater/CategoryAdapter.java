package com.example.khoavx.accessoriceshop.Apdater;

import android.content.Context;
import androidx.recyclerview.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;


import com.example.khoavx.accessoriceshop.Model.Category;
import com.example.khoavx.accessoriceshop.R;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;

/**
 * Created by vandongluong on 7/31/18.
 */
public class CategoryAdapter extends RecyclerView.Adapter<CategoryAdapter.ViewHolder> {


    Context context;
    List<Category> categories;

    private OnItemClickListener onItemClickListener;

    public CategoryAdapter(Context context, List<Category> categories) {
        this.context = context;
        this.categories = categories;
    }

    public interface OnItemClickListener {
        void onItemClicked(Category category);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_category_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        Category category = categories.get(position);
        holder.t_name_menu.setText(category.getCategory_name());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onItemClickListener(category);
            }
        });
    }

    @Override
    public int getItemCount() {
        return categories.size();
    }


    public void onItemClickListener(Category category) {
        if (CategoryAdapter.this.onItemClickListener != null) {
            CategoryAdapter.this.onItemClickListener.onItemClicked(category);
        }
    }

    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public class ViewHolder extends RecyclerView.ViewHolder{
        @BindView(R.id.t_name_menu)
        TextView t_name_menu;

        public ViewHolder(View view) {
            super(view);
            ButterKnife.bind(this, view);
        }
    }
}