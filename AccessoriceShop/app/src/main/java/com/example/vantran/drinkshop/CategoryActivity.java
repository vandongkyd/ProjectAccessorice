package com.example.vantran.drinkshop;

import android.content.Intent;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.ButtonBarLayout;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.TextView;

import com.example.vantran.drinkshop.Apdater.CategoryAdapter;
import com.example.vantran.drinkshop.Model.Category;
import com.example.vantran.drinkshop.Retrofit.ICallShopAPI;
import com.example.vantran.drinkshop.Utils.Common;

import java.util.ArrayList;
import java.util.List;

import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;

public class CategoryActivity extends AppCompatActivity {

    List<Category> localDataSource = new ArrayList<>();
    RecyclerView rv_drink;
    TextView t_name_menu;
    ICallShopAPI iCallShopAPI;
    ButtonBarLayout btn_back;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    SwipeRefreshLayout swipe_to_ref;
    CategoryAdapter categoryAdapter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_category);

        iCallShopAPI = Common.callAPI();
        rv_drink = (RecyclerView)findViewById(R.id.rv_drink);
        t_name_menu = (TextView)findViewById(R.id.t_menu_name);
        swipe_to_ref = (SwipeRefreshLayout)findViewById(R.id.swipe_to_ref);
        btn_back = (ButtonBarLayout)findViewById(R.id.btn_back);
        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });


        rv_drink.setLayoutManager(new GridLayoutManager(this,2));
        rv_drink.setHasFixedSize(true);

        loadListCategory(Common.currentBrand.getId());
        t_name_menu.setText(Common.currentBrand.getBrand_name());

        swipe_to_ref.post(new Runnable() {
            @Override
            public void run() {
                swipe_to_ref.setRefreshing(true);
                loadListCategory(Common.currentBrand.getId());
            }
        });
        swipe_to_ref.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                swipe_to_ref.setRefreshing(true);
                loadListCategory(Common.currentBrand.getId());
            }
        });
    }

    private void loadListCategory(String id) {
        compositeDisposable.add(iCallShopAPI.getCategory(id)
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Consumer<List<Category>>() {
                    @Override
                    public void accept(List<Category> categories) throws Exception {
                        displayDrink(categories);
//                        Common.toppingList = drinks;
                    }
                })
        );
    }

    private void displayDrink(List<Category> categories) {
        localDataSource = categories;
        categoryAdapter = new CategoryAdapter(this, categories);
        categoryAdapter.setOnItemClickListener(clickListener);
        rv_drink.setAdapter(categoryAdapter);
        swipe_to_ref.setRefreshing(false);
    }

    private CategoryAdapter.OnItemClickListener clickListener = new CategoryAdapter.OnItemClickListener() {

        @Override
        public void onItemClicked(Category category) {
            Common.currentCategory = category;
            startActivity(new Intent(CategoryActivity.this, ProductActivity.class));
        }
    };
}
