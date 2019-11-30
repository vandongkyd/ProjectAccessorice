package com.example.vantran.drinkshop.Database.ModelDB;

import android.arch.persistence.room.ColumnInfo;
import android.arch.persistence.room.Entity;
import android.arch.persistence.room.PrimaryKey;
import android.support.annotation.NonNull;

/**
 * Created by vandongluong on 10/20/18.
 */
@Entity(tableName = "Cart")
public class Cart {

    @NonNull
    @PrimaryKey(autoGenerate = true)
    @ColumnInfo(name = "id")
    public int id;

    @ColumnInfo(name = "name")
    public String name;

    @ColumnInfo(name = "images")
    public String images;

    @ColumnInfo(name = "amount")
    public double amount;

    @ColumnInfo(name = "product_id")
    public String product_id;

    @ColumnInfo(name = "quality_item")
    public int quality_item;


}
