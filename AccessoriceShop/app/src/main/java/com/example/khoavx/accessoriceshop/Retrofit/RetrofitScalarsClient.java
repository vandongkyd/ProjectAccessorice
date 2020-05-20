package com.example.khoavx.accessoriceshop.Retrofit;

import retrofit2.Retrofit;
import retrofit2.converter.scalars.ScalarsConverterFactory;

/**
 * Created by vandongluong on 10/18/18.
 */

public class RetrofitScalarsClient {
    private static Retrofit retrofit = null;
    public static Retrofit getScalarsClient(String baseUrl){
        if (retrofit == null){
            retrofit = new Retrofit.Builder()
                    .baseUrl(baseUrl)
                    .addConverterFactory(ScalarsConverterFactory.create())
                    .build();
        }
        return retrofit;
    }
}
