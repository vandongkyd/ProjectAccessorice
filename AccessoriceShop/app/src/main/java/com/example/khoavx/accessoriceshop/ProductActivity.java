package com.example.khoavx.accessoriceshop;

import android.content.Intent;
import android.graphics.Color;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;
import androidx.appcompat.app.AppCompatActivity;
import android.os.Bundle;
import androidx.appcompat.widget.ButtonBarLayout;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.khoavx.accessoriceshop.Apdater.ProductAdapter;
import com.example.khoavx.accessoriceshop.Model.Product;
import com.example.khoavx.accessoriceshop.Retrofit.ICallShopAPI;
import com.example.khoavx.accessoriceshop.Utils.Common;

import java.util.ArrayList;
import java.util.List;

import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;

public class ProductActivity extends AppCompatActivity {

    List<Product> localDataSource = new ArrayList<>();
    RecyclerView rv_drink;
    TextView t_name_menu;
    ICallShopAPI iCallShopAPI;
    ButtonBarLayout btn_back;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    SwipeRefreshLayout swipe_to_ref;
    androidx.appcompat.widget.SearchView searchView;
    ProductAdapter drinkAdapter;
    TextView cart_badge;
    ImageView icon_card;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_product);
        iCallShopAPI = Common.callAPI();
        rv_drink = (RecyclerView)findViewById(R.id.rv_drink);
        t_name_menu = (TextView)findViewById(R.id.t_menu_name);
        swipe_to_ref = (SwipeRefreshLayout)findViewById(R.id.swipe_to_ref);
        btn_back = (ButtonBarLayout)findViewById(R.id.btn_back);
        cart_badge = (TextView)findViewById(R.id.cart_badge);
        icon_card = (ImageView)findViewById(R.id.icon_card);
        searchView = (androidx.appcompat.widget.SearchView)findViewById(R.id.searchView);
        EditText searchEditText = (EditText)searchView.findViewById(R.id.search_src_text);
        searchEditText.setTextColor(Color.parseColor("#000000"));
        searchEditText.setHintTextColor(Color.parseColor("#000000"));
        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        Search(searchView);

        rv_drink.setLayoutManager(new GridLayoutManager(this,2));
        rv_drink.setHasFixedSize(true);

        loadListDrink(Common.currentCategory.getId());
        t_name_menu.setText(Common.currentCategory.getCategory_name());

        swipe_to_ref.post(new Runnable() {
            @Override
            public void run() {
                swipe_to_ref.setRefreshing(true);
                loadListDrink(Common.currentCategory.getId());
            }
        });
        swipe_to_ref.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                swipe_to_ref.setRefreshing(true);
                loadListDrink(Common.currentCategory.getId());
            }
        });

        if (Common.currentCustomer != null) {
            icon_card.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    startActivity(new Intent(ProductActivity.this, CartActivity.class));
                }
            });
            updateCartCount();
        }

    }

    private void loadListDrink(String id) {
        compositeDisposable.add(iCallShopAPI.getProduct(id)
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Consumer<List<Product>>() {
                    @Override
                    public void accept(List<Product> drinks) throws Exception {
                        displayDrink(drinks);
                    }
                })
        );
    }

    private void displayDrink(List<Product> drinks) {
        localDataSource = drinks;
        drinkAdapter = new ProductAdapter(this, drinks);
        drinkAdapter.setOnItemClickListener(clickListener);
        rv_drink.setAdapter(drinkAdapter);
        swipe_to_ref.setRefreshing(false);
    }

    private ProductAdapter.OnItemClickListener clickListener = new ProductAdapter.OnItemClickListener() {

        @Override
        public void onItemClicked(Product drink) {
            Common.currentProduct = drink;
            startActivity(new Intent(ProductActivity.this, ProductDetailActivity.class));
        }
    };



    @Override
    protected void onPostResume() {
        super.onPostResume();
    }

    public void Search(androidx.appcompat.widget.SearchView searchView){
        searchView.setOnQueryTextListener(new androidx.appcompat.widget.SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String s) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String s) {
                drinkAdapter.getFilter().filter(s);
                return false;
            }
        });
    }

    private void updateCartCount() {
        if (cart_badge == null) return;
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                if (Common.cartRepository.countCartItems() == 0){
                    cart_badge.setVisibility(View.INVISIBLE);
                }else {
                    cart_badge.setVisibility(View.VISIBLE);
                    cart_badge.setText(String.valueOf(Common.cartRepository.countCartItems()));
                }
            }
        });
    }
}
