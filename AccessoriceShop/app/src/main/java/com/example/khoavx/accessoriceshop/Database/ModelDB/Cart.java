package com.example.khoavx.accessoriceshop.Database.ModelDB;

import androidx.annotation.NonNull;
import androidx.room.ColumnInfo;
import androidx.room.Entity;
import androidx.room.PrimaryKey;

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
