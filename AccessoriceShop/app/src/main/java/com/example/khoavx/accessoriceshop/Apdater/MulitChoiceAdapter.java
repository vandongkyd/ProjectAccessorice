package com.example.khoavx.accessoriceshop.Apdater;

import android.content.Context;
import androidx.recyclerview.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CheckBox;
import android.widget.CompoundButton;

import com.example.khoavx.accessoriceshop.Model.Drink;
import com.example.khoavx.accessoriceshop.R;
import com.example.khoavx.accessoriceshop.Utils.Common;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;


public class MulitChoiceAdapter extends RecyclerView.Adapter<MulitChoiceAdapter.ViewHolder> {


    Context context;
    List<Drink> drinks;

    private OnItemClickListener onItemClickListener;

    public MulitChoiceAdapter(Context context, List<Drink> drinks) {
        this.context = context;
        this.drinks = drinks;
    }

    public interface OnItemClickListener {
        void onItemClicked(Drink drink);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_multi_check, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, int position) {
        Drink drink = drinks.get(position);

        holder.cb_tp.setText(drink.getName());
        holder.cb_tp.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if (isChecked){
                    Common.toppingAdded.add(buttonView.getText().toString());
                    Common.toppingPrice += Double.valueOf(drink.getPrice());
                }else {
                    Common.toppingAdded.remove(buttonView.getText().toString());
                    Common.toppingPrice -= Double.valueOf(drink.getPrice());
                }
            }
        });
    }

    @Override
    public int getItemCount() {
        return drinks.size();
    }


//    public void onItemClickListener(Category category) {
//        if (MulitChoiceAdapter.this.onItemClickListener != null) {
//            MulitChoiceAdapter.this.onItemClickListener.onItemClicked(category);
//        }
//    }

    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public class ViewHolder extends RecyclerView.ViewHolder{

        @BindView(R.id.cb_tp)
        CheckBox cb_tp;

        public ViewHolder(View view) {
            super(view);
            ButterKnife.bind(this, view);
        }
    }
}