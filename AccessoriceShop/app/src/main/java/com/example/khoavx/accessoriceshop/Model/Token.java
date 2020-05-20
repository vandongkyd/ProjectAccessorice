package com.example.khoavx.accessoriceshop.Model;

/**
 * Created by vandongluong on 10/29/18.
 */

public class Token {
    private String Phone;
    private String Token;
    private String IsServerToken;

    public Token() {
    }

    public String getPhone() {
        return Phone;
    }

    public void setPhone(String phone) {
        Phone = phone;
    }

    public String getToken() {
        return Token;
    }

    public void setToken(String token) {
        Token = token;
    }

    public String getIsServerToken() {
        return IsServerToken;
    }

    public void setIsServerToken(String isServerToken) {
        IsServerToken = isServerToken;
    }
}
