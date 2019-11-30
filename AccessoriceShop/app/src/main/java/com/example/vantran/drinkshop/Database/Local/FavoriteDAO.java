package com.example.vantran.drinkshop.Database.Local;

import android.arch.persistence.room.Dao;
import android.arch.persistence.room.Delete;
import android.arch.persistence.room.Insert;
import android.arch.persistence.room.Query;

import com.example.vantran.drinkshop.Database.ModelDB.Favorite;

import java.util.List;

import io.reactivex.Flowable;

/**
 * Created by vandongluong on 10/20/18.
 */
@Dao
public interface FavoriteDAO {
    @Query("SELECT * FROM Favorite")
    Flowable<List<Favorite>> getFavoriteItems();

    @Query("SELECT EXISTS(SELECT 1 FROM Favorite WHERE id=:itemId)")
    int isFavoriteItems(int itemId);

    @Insert
    void insertToFavorite(Favorite...favorites);

    @Delete
    void deleteFavoriteItems(Favorite favorite);
}
