package com.example.khoavx.accessoriceshop.Database.Local;

import androidx.room.Dao;
import androidx.room.Delete;
import androidx.room.Insert;
import androidx.room.Query;

import com.example.khoavx.accessoriceshop.Database.ModelDB.Favorite;

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
