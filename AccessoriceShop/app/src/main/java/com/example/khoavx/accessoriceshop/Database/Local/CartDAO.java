package com.example.khoavx.accessoriceshop.Database.Local;

import androidx.room.Dao;
import androidx.room.Delete;
import androidx.room.Insert;
import androidx.room.Query;
import androidx.room.Update;

import com.example.khoavx.accessoriceshop.Database.ModelDB.Cart;

import java.util.List;

import io.reactivex.Flowable;


@Dao
public interface CartDAO {
    @Query("SELECT * FROM Cart")
    Flowable<List<Cart>> getCartItems();

    @Query("SELECT * FROM Cart WHERE id=:cartItemId")
    Flowable<List<Cart>> getCartItemsById(int cartItemId);

    @Query("SELECT SUM(Amount) from Cart")
    float submitPrice();

    @Query("SELECT COUNT(*) from Cart")
    int countCartItems();

    @Query("DELETE FROM Cart")
    void emptyCart();

    @Insert
    void insertToCart(Cart...carts);

    @Update
    void updateCart(Cart...carts);

    @Delete
    void deleteCartItems(Cart cart);
}
