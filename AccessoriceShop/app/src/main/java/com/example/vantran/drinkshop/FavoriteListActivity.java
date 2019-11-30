package com.example.vantran.drinkshop;

import android.graphics.Color;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.ButtonBarLayout;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.helper.ItemTouchHelper;
import android.view.View;
import android.widget.RelativeLayout;

import com.example.vantran.drinkshop.Apdater.FavoriteAdapter;
import com.example.vantran.drinkshop.Apdater.LikeAdapter;
import com.example.vantran.drinkshop.Database.ModelDB.Favorite;
import com.example.vantran.drinkshop.Utils.Common;
import com.example.vantran.drinkshop.Utils.RecyclerItemTouchHelper;
import com.example.vantran.drinkshop.Utils.RecyclerItemTouchHelperListenner;

import java.util.ArrayList;
import java.util.List;

import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;

public class FavoriteListActivity extends AppCompatActivity  {

    RecyclerView rv_favorite;
    RelativeLayout rootLayout;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    FavoriteAdapter adapter;
    LikeAdapter likeAdapter;
    List<Favorite> localFavorite = new ArrayList<>();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_favorite_list);
        rv_favorite = (RecyclerView)findViewById(R.id.rv_farovite);
        rootLayout = (RelativeLayout)findViewById(R.id.rootLayout);

        ButtonBarLayout btn_back = (ButtonBarLayout)findViewById(R.id.btn_back);
        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        rv_favorite.setLayoutManager(new GridLayoutManager(this,2));
        rv_favorite.setHasFixedSize(true);

        loadFavorite();
    }

    @Override
    protected void onResume() {
        super.onResume();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        compositeDisposable.clear();
    }

    private void loadFavorite() {
        compositeDisposable.add(Common.favoriteRepository.getFavoriteItems()
                .observeOn(AndroidSchedulers.mainThread())
                .subscribeOn(Schedulers.io())
                .subscribe(new Consumer<List<Favorite>>() {
                    @Override
                    public void accept(List<Favorite> favorites) throws Exception {
                        displayFavorite(favorites);
                    }
                })
        );
    }

    private void displayFavorite(List<Favorite> favorites) {
        localFavorite = favorites;
        likeAdapter = new LikeAdapter(this, favorites);
        rv_favorite.setAdapter(likeAdapter);
    }
}
