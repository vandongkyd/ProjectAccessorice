package com.example.khoavx.accessoriceshop.Database.Local;

import androidx.room.Database;
import androidx.room.Room;
import androidx.room.RoomDatabase;
import android.content.Context;

import com.example.khoavx.accessoriceshop.Database.ModelDB.Cart;
import com.example.khoavx.accessoriceshop.Database.ModelDB.Favorite;

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
