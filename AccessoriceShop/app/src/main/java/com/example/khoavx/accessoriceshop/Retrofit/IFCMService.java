package com.example.khoavx.accessoriceshop.Retrofit;

import com.example.khoavx.accessoriceshop.Model.DataMessage;
import com.example.khoavx.accessoriceshop.Model.MyResponse;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.Headers;
import retrofit2.http.POST;

/**
 * Created by vandongluong on 10/29/18.
 */

public interface IFCMService {
    @Headers({
            "Content-Type: application/json",
            "Authorization:key=AAAAwk7hZPI:APA91bFb9kF2HSQEFfP3VJgviFF1rklAJeTrwgVmxvtwr7cdum9BLbhD_ZfWwtXt2XWdDyDohaowhSEOKN700_n712ApskKcYmiVAL-ruvufpd9r4iofoT2fiXuRCs8uPrwtNa-kwdIe"
    })
    @POST("fcm/send")
    Call<MyResponse> sendNotification(@Body DataMessage body);
}
