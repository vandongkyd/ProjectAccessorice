package com.example.khoavx.accessoriceshop.Utils;

import android.content.DialogInterface;
import android.content.Intent;
import android.util.Log;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.example.khoavx.accessoriceshop.Database.DataSource.CartRepository;
import com.example.khoavx.accessoriceshop.Database.DataSource.FavoriteRepository;
import com.example.khoavx.accessoriceshop.Database.Local.EMDTRoomDatabase;
import com.example.khoavx.accessoriceshop.MainActivity;
import com.example.khoavx.accessoriceshop.Model.Brand;
import com.example.khoavx.accessoriceshop.Model.Category;
import com.example.khoavx.accessoriceshop.Model.Customer;
import com.example.khoavx.accessoriceshop.Model.Drink;
import com.example.khoavx.accessoriceshop.Model.Invoice;
import com.example.khoavx.accessoriceshop.Model.Order;
import com.example.khoavx.accessoriceshop.Model.Product;
import com.example.khoavx.accessoriceshop.Model.User;
import com.example.khoavx.accessoriceshop.Retrofit.ICallShopAPI;
import com.example.khoavx.accessoriceshop.Retrofit.IFCMClient;
import com.example.khoavx.accessoriceshop.Retrofit.IFCMService;
import com.example.khoavx.accessoriceshop.Retrofit.RetrofitClient;
import com.facebook.accountkit.AccountKit;

import java.text.DecimalFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

/**
 * Created by vandongluong on 10/18/18.
 */

public class Common {
    // url http api
    private static final String HOST = "http://192.168.1.14:8000";
    private static final String HOST_API = "http://192.168.1.14:8000";
    public static final String BASE_URL_API = HOST_API + "/api/";
    public static final String API_TOKEN_URL = HOST + "/shopdrink/braintree/main.php";
    public static final String BASE_URL_IMAGE_API = HOST_API + "/upload/";

    public static final String TOPPING_MENU_ID = "7";
    public static User currentUser = null;
    public static Customer currentCustomer = null;
    public static Category currentCategory = null;
    public static Product currentProduct = null;
    public static Brand currentBrand = null;
    public static Order currentOrder = null;
    public static Invoice currentInvoice = null;
    public static Drink currentDrink = null;
    public static List<Drink> toppingList = new ArrayList<>();

    public static double toppingPrice = 0.0;
    public static List<String> toppingAdded = new ArrayList<>();
    public static int sizeOfCup = -1; // -1 : no choose (error), 0 : M , 1 : L
    public static int sugar = -1; // -1 : no choose (error)
    public static int ice = -1;//

    public static EMDTRoomDatabase EMDTRoomDatabase;
    public static CartRepository cartRepository;
    public static FavoriteRepository favoriteRepository;

    public static ICallShopAPI callAPI(){
        return RetrofitClient.getClient(BASE_URL_API).create(ICallShopAPI.class);
    }

    public static String convertCodeToStatus(int orderStatus) {
        switch (orderStatus){
            case 0:
                return "Placed";
            case 1:
                return "Processing";
            case 2:
                return "Shipping";
            case 3:
                return "Shipped";
            case 4:
                return "Canceled";
                default:
                    return "Order Error";
        }
    }


    private static final String FCM_API = "https://fcm.googleapis.com/";
    public static IFCMService getifcmClient(){
        return IFCMClient.getClient(FCM_API).create(IFCMService.class);
    }


    public static String getDateFormat(String timeStamp){
        try{
            long d = Long.parseLong(timeStamp);
            Date date = new Date(d*1000L);
            // format of the date
            SimpleDateFormat jdf = new SimpleDateFormat("yyyy-MM-dd");
            String java_date = jdf.format(date);
            return java_date;
        }catch (Exception e){

        }
        return null;
    }

    public static String getMonthFormat(String timeStamp){
        try{
            long d = Long.parseLong(timeStamp);
            Date date = new Date(d*1000L);
            // format of the date
            SimpleDateFormat jdf = new SimpleDateFormat("yyyy-MM");
            String java_date = jdf.format(date);
            return java_date;
        }catch (Exception e){
            Log.d("Error", e.getMessage());
        }
        return null;
    }

    public static String formatNumber(double number){
        DecimalFormat formatter = new DecimalFormat("#,###,###");
        return formatter.format(number);
    }


    public static void PopupMessages(String mes, AppCompatActivity activity){
        AlertDialog.Builder builder = new AlertDialog.Builder(activity);
        builder.setTitle("Message");
        builder.setMessage("Please Login To Use This "+ mes);
        builder.setNegativeButton("CANCEL", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });

        builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                AccountKit.logOut();
                Intent i = new Intent(activity, MainActivity.class);
                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                activity.startActivity(i);
            }
        });
        builder.show();
    }
}
