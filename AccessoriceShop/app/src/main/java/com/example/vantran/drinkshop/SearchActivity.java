package com.example.vantran.drinkshop;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.ButtonBarLayout;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.EditText;
import android.widget.SearchView;
import android.widget.Toast;

import com.example.vantran.drinkshop.Apdater.ProductAdapter;
import com.example.vantran.drinkshop.Model.Banner;
import com.example.vantran.drinkshop.Model.Drink;
import com.example.vantran.drinkshop.Model.Product;
import com.example.vantran.drinkshop.Retrofit.ICallShopAPI;
import com.example.vantran.drinkshop.Utils.Common;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;

public class SearchActivity extends AppCompatActivity {

    List<String> suggestList = new ArrayList<>();
    List<Product> localDataSource = new ArrayList<>();

    @BindView(R.id.search_buyer)
    SearchView searchBar;
    @BindView(R.id.rv_search)
    RecyclerView rv_search;
    @BindView(R.id.ed_search)
    EditText ed_search;
    @BindView(R.id.btn_back)
    ButtonBarLayout btn_back;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    ICallShopAPI iCallShopAPI;


    ProductAdapter adapter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search);
        ButterKnife.bind(this);
        iCallShopAPI = Common.callAPI();

        rv_search.setLayoutManager(new GridLayoutManager(this, 2));
        rv_search.setHasFixedSize(true);
        loadAllDrink();
        SearchDrink();
        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }

    public void SearchDrink(){
        ed_search.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                adapter.getFilter().filter(s);
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });
    }


    private void loadAllDrink() {
        compositeDisposable.add(iCallShopAPI.getProductAll()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Consumer<List<Product>>() {
                    @Override
                    public void accept(List<Product> banners) throws Exception {
                        displayAllDrink(banners);
                    }
                })
        );
    }

    private void displayAllDrink(List<Product> drinks) {
        localDataSource = drinks;
        adapter = new ProductAdapter(this,drinks);
        rv_search.setAdapter(adapter);
    }
}
