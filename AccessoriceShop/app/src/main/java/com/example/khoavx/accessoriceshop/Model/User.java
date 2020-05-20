package com.example.khoavx.accessoriceshop.Model;

/**
 * Created by vandongluong on 10/18/18.
 */

public class User {
    private String phone;
    private String avatar;
    private String name;
    private String birthdate;
    private String address;
    private String key;
    private String mgs_error;

    public User() {
    }

    public String getPhone() {
        return phone;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }

    public String getAvatar() {
        return avatar;
    }

    public void setAvatar(String avatar) {
        this.avatar = avatar;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getBirthdate() {
        return birthdate;
    }

    public void setBirthdate(String birthdate) {
        this.birthdate = birthdate;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getMgs_error() {
        return mgs_error;
    }

    public void setMgs_error(String mgs_error) {
        this.mgs_error = mgs_error;
    }

    public String getKey() {
        return key;
    }

    public void setKey(String key) {
        this.key = key;
    }
}
