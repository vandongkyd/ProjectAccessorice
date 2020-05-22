package com.example.khoavx.accessoriceshop.Database.ModelDB;

import androidx.annotation.NonNull;
import androidx.room.ColumnInfo;
import androidx.room.Entity;
import androidx.room.PrimaryKey;



@Entity(tableName = "Favorite")
public class Favorite {

    @NonNull
    @PrimaryKey(autoGenerate = true)
    @ColumnInfo(name = "id")
    public int id;

    @ColumnInfo(name = "name")
    public String name;

    @ColumnInfo(name = "images")
    public String images;

    @ColumnInfo(name = "price")
    public double price;

    @ColumnInfo(name = "productId")
    public int productId;

    @ColumnInfo(name = "phone")
    public String phone;
}
