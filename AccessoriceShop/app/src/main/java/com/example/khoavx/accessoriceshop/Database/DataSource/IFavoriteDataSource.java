package com.example.khoavx.accessoriceshop.Database.DataSource;

import com.example.khoavx.accessoriceshop.Database.ModelDB.Favorite;

import java.util.List;

import io.reactivex.Flowable;


public interface IFavoriteDataSource {
    Flowable<List<Favorite>> getFavoriteItems();
    int isFavoriteItems(int itemId);
    void insertToFavorite(Favorite... favorite);
    void deleteFavoriteItems(Favorite favorite);
}
