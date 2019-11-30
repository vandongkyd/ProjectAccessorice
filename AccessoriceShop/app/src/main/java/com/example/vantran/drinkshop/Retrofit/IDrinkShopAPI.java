package com.example.vantran.drinkshop.Retrofit;

import com.example.vantran.drinkshop.Model.Banner;
import com.example.vantran.drinkshop.Model.CheckUserResponse;
import com.example.vantran.drinkshop.Model.Category;
import com.example.vantran.drinkshop.Model.Drink;
import com.example.vantran.drinkshop.Model.Order;
import com.example.vantran.drinkshop.Model.OrderResulft;
import com.example.vantran.drinkshop.Model.Store;
import com.example.vantran.drinkshop.Model.Token;
import com.example.vantran.drinkshop.Model.User;

import java.util.List;
import io.reactivex.Observable;

import okhttp3.MultipartBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;

/**
 * Created by vandongluong on 10/18/18.
 */

public interface IDrinkShopAPI {
//    // Call API check user
//    @FormUrlEncoded
//    @POST("checkuser.php")
//    Call<CheckUserResponse> checkUserExits(
//      @Field("phone") String phone
//    );
//
//    //Call API register User
//    @FormUrlEncoded
//    @POST("register.php")
//    Call<User> user(
//      @Field("phone") String phone,
//      @Field("name") String name,
//      @Field("birthdate") String birthdate,
//      @Field("address") String address
//    );
//
//    //Call API user login
//    @FormUrlEncoded
//    @POST("getuser.php")
//    Call<User> getUserInfor(
//            @Field("phone") String phone
//    );
//
////    //Call API list banner
////    @GET("getbanner.php")
////    Observable<List<Banner>> getBanner();
//
//    // Call API list Menu
//    @GET("getmenu.php")
//    Observable<List<Category>> getMenu();
//
//    //Call API Drink by menuid
//    @FormUrlEncoded
//    @POST("getdrink.php")
//    Observable<List<Drink>> getDrink(
//            @Field("menuid") String menuid
//    );
//
//    @Multipart
//    @POST("uploadAv.php")
//    Call<String> uploadFile(
//            @Part MultipartBody.Part phone,
//            @Part MultipartBody.Part file
//    );
//
//    @GET("getalldrink.php")
//    Observable<List<Drink>> getalldrink();
//
//    //Call API register User
//    @FormUrlEncoded
//    @POST("submitorder.php")
//    Call<OrderResulft> neworder(
//            @Field("price") String price,
//            @Field("orderDetail") String orderDtail,
//            @Field("comment") String comment,
//            @Field("address") String address,
//            @Field("phone") String phone,
//            @Field("payment") String payment
//    );
//
//    //Call API register User
//    @FormUrlEncoded
//    @POST("braintree/checkout.php")
//    Call<String> payment(
//            @Field("nonce") String nonce,
//            @Field("amount") String amount
//    );
//
//    //Call API Drink by menuid
//    @FormUrlEncoded
//    @POST("getorderbystatus.php")
//    Observable<List<Order>> getOrderbyStatus(
//            @Field("phone") String phone,
//            @Field("status") String status
//    );
//
//    //Call API register User
//    @FormUrlEncoded
//    @POST("updatetoken.php")
//    Call<String> token(
//            @Field("phone") String phone,
//            @Field("token") String token,
//            @Field("isServerToken") String isServerToken
//    );
//
//
//    @FormUrlEncoded
//    @POST("cancelorder.php")
//    Call<String> cancelorder(
//            @Field("phone") String phone,
//            @Field("orderid") String orderid
//    );
//
//    @FormUrlEncoded
//    @POST("getnearbystore.php")
//    Observable<List<Store>> getnearbystore(
//            @Field("lat") double lat,
//            @Field("lng") double lng
//    );
//
//    //Call API register User
//    @FormUrlEncoded
//    @POST("gettoken.php")
//    Call<Token> gettoken(
//            @Field("phone") String phone,
//            @Field("isServerToken") String isServerToken
//    );

}
