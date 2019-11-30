package com.example.vantran.drinkshop.Database.Local;

import android.arch.persistence.room.Database;
import android.arch.persistence.room.Room;
import android.arch.persistence.room.RoomDatabase;
import android.content.Context;

import com.example.vantran.drinkshop.Database.ModelDB.Cart;
import com.example.vantran.drinkshop.Database.ModelDB.Favorite;

/**
 * Created by vandongluong on 10/20/18.
 */
@Database(entities = {Cart.class, Favorite.class}, version = 2, exportSchema = false)
public abstract class EMDTRoomDatabase extends RoomDatabase {

    public abstract CartDAO cartDAO();
    public abstract FavoriteDAO favoriteDAO();
    private static EMDTRoomDatabase instance;

    public static EMDTRoomDatabase getInstance(Context context){
        if (instance == null){
            instance = Room.databaseBuilder(context,EMDTRoomDatabase.class,"EDMT_DrinkShopDB")
                    .allowMainThreadQueries()
                    .build();

        }
        return instance;
    }
}
