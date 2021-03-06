package com.example.khoavx.accessoriceshop.Retrofit;

import com.example.khoavx.accessoriceshop.Model.Banner;
import com.example.khoavx.accessoriceshop.Model.Brand;
import com.example.khoavx.accessoriceshop.Model.Category;
import com.example.khoavx.accessoriceshop.Model.CheckUserResponse;
import com.example.khoavx.accessoriceshop.Model.Customer;
import com.example.khoavx.accessoriceshop.Model.Invoice;
import com.example.khoavx.accessoriceshop.Model.InvoiceDetail;
import com.example.khoavx.accessoriceshop.Model.Product;
import com.example.khoavx.accessoriceshop.Model.ProductImage;


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

public interface ICallShopAPI {

    //Call API list banner
    @GET("banners")
    Observable<List<Banner>> getBanner();


    @GET("brands")
    Observable<List<Brand>> getBrand();

    @GET("productall")
    Observable<List<Product>> getProductAll();

    @FormUrlEncoded
    @POST("categories")
    Observable<List<Category>> getCategory(
            @Field("brandId") String brandId
    );

    @FormUrlEncoded
    @POST("products")
    Observable<List<Product>> getProduct(
            @Field("categoryId") String categoryId
    );

    @FormUrlEncoded
    @POST("imagesproduct")
    Observable<List<ProductImage>> getProductImages(
            @Field("productId") String productId
    );

    @FormUrlEncoded
    @POST("productsbyid")
    Call<Product> getProductId(
            @Field("productId") String productId
    );

    //Call API register User
    @FormUrlEncoded
    @POST("login")
    Call<Customer> customer(
            @Field("username") String username,
            @Field("password") String password
    );

    //Call API register User
    @FormUrlEncoded
    @POST("register")
    Call<Customer> register(
            @Field("username") String username,
            @Field("password") String password,
            @Field("email") String email,
            @Field("phone") String phone
    );

    // Call API check user
    @FormUrlEncoded
    @POST("checkcustomer")
    Call<CheckUserResponse> checkUserExits(
            @Field("username") String username,
            @Field("email") String email
    );

    @Multipart
    @POST("avatar")
    Call<String> uploadAvatar(
            @Part MultipartBody.Part customerId,
            @Part MultipartBody.Part avatar
    );

    //Call API register User
    @FormUrlEncoded
    @POST("order")
    Call<Invoice> newOrder(
            @Field("total_amount") String total_amount,
            @Field("recipient_name") String recipient_name,
            @Field("customer_id") String customer_id,
            @Field("address") String address,
            @Field("phone") String phone,
            @Field("payment_status") String payment_status,
            @Field("ship_id") String ship_id,
            @Field("type_delivery") String type_delivery,
            @Field("discount_code") String discount_code,
            @Field("invoiceDetail") String invoiceDetail
    );

    @FormUrlEncoded
    @POST("invoicelist")
    Observable<List<Invoice>> getInvoice(
            @Field("customer_id") String customerId,
            @Field("status") String status
    );

    @FormUrlEncoded
    @POST("invoiceDetail")
    Observable<List<InvoiceDetail>> getInvoiceDetail(
            @Field("invoice_id") String invoiceId
    );

    @FormUrlEncoded
    @POST("canceled")
    Call<String> cancelOrder(
            @Field("invoice_id") String invoiceId
    );

    //Call API register User
    @FormUrlEncoded
    @POST("change-info")
    Call<Customer> changeinfo(
            @Field("id") String id,
            @Field("first_name") String first_name,
            @Field("last_name") String last_name,
            @Field("address") String address,
            @Field("gender") String gender
    );

}
