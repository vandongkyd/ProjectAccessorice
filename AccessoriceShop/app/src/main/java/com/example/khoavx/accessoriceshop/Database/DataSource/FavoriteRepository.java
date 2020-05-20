package com.example.khoavx.accessoriceshop.Database.DataSource;

import com.example.khoavx.accessoriceshop.Database.ModelDB.Favorite;

import java.util.List;

import io.reactivex.Flowable;

/**
 * Created by vandongluong on 10/20/18.
 */

public class FavoriteRepository implements IFavoriteDataSource {

    private IFavoriteDataSource iFavoriteDataSource;

    public FavoriteRepository(IFavoriteDataSource iFavoriteDataSource) {
        this.iFavoriteDataSource = iFavoriteDataSource;
    }

    private static FavoriteRepository instance;

    public static FavoriteRepository getInstance(IFavoriteDataSource iFavoriteDataSource) {
        if (instance == null){
            instance = new FavoriteRepository(iFavoriteDataSource);
        }
        return instance;
    }

    @Override
    public Flowable<List<Favorite>> getFavoriteItems() {
        return iFavoriteDataSource.getFavoriteItems();
    }

    @Override
    public int isFavoriteItems(int itemId) {
        return iFavoriteDataSource.isFavoriteItems(itemId);
    }


    @Override
    public void insertToFavorite(Favorite... favorite) {
        iFavoriteDataSource.insertToFavorite(favorite);
    }


    @Override
    public void deleteFavoriteItems(Favorite favorite) {
        iFavoriteDataSource.deleteFavoriteItems(favorite);
    }
}
