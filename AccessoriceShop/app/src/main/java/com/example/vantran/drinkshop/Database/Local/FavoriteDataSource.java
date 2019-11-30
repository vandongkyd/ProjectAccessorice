package com.example.vantran.drinkshop.Database.Local;

import com.example.vantran.drinkshop.Database.DataSource.IFavoriteDataSource;
import com.example.vantran.drinkshop.Database.ModelDB.Favorite;

import java.util.List;

import io.reactivex.Flowable;

/**
 * Created by vandongluong on 10/20/18.
 */

public class FavoriteDataSource implements IFavoriteDataSource {

    private FavoriteDAO favoriteDAO;
    private static FavoriteDataSource instance;

    public FavoriteDataSource(FavoriteDAO favoriteDAO) {
        this.favoriteDAO = favoriteDAO;
    }

    public static FavoriteDataSource getInstance(FavoriteDAO favoriteDAO) {
        if (instance == null){
            instance = new FavoriteDataSource(favoriteDAO);
        }
        return instance;
    }


    @Override
    public Flowable<List<Favorite>> getFavoriteItems() {
        return favoriteDAO.getFavoriteItems();
    }

    @Override
    public int isFavoriteItems(int itemId) {
        return favoriteDAO.isFavoriteItems(itemId);
    }


    @Override
    public void insertToFavorite(Favorite... favorite) {
        favoriteDAO.insertToFavorite(favorite);
    }


    @Override
    public void deleteFavoriteItems(Favorite favorite) {
        favoriteDAO.deleteFavoriteItems(favorite);
    }
}
