package com.example.khoavx.accessoriceshop.Database.DataSource;

import com.example.khoavx.accessoriceshop.Database.ModelDB.Cart;

import java.util.List;

import io.reactivex.Flowable;



public interface ICartDataSource {
    Flowable<List<Cart>> getCartItems();
    Flowable<List<Cart>> getCartItemsById(int cartItemId);
    int countCartItems();
    float sumPrice();
    void emptyCart();
    void insertToCart(Cart...carts);
    void updateCart(Cart...carts);
    void deleteCartItems(Cart cart);
}
