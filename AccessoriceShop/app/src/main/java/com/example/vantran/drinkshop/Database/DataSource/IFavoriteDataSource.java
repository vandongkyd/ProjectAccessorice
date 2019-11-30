package com.example.vantran.drinkshop.Database.DataSource;

import com.example.vantran.drinkshop.Database.ModelDB.Favorite;

import java.util.List;

import io.reactivex.Flowable;

/**
 * Created by vandongluong on 10/20/18.
 */

public interface IFavoriteDataSource {
    Flowable<List<Favorite>> getFavoriteItems();
    int isFavoriteItems(int itemId);
    void insertToFavorite(Favorite... favorite);
    void deleteFavoriteItems(Favorite favorite);
}
