package com.example.khoavx.accessoriceshop.Model;


public class Store {
    private String id;
    private String name;
    private String country;
    private double lat;
    private double lng;
    private String distance_in_km;

    public Store() {
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getCountry() {
        return country;
    }

    public void setCountry(String country) {
        this.country = country;
    }

    public double getLat() {
        return lat;
    }

    public void setLat(double lat) {
        this.lat = lat;
    }

    public double getLng() {
        return lng;
    }

    public void setLng(double lng) {
        this.lng = lng;
    }

    public String getDistance_in_km() {
        return distance_in_km;
    }

    public void setDistance_in_km(String distance_in_km) {
        this.distance_in_km = distance_in_km;
    }
}
