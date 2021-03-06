package com.example.khoavx.accessoriceshop.Utils;

import android.annotation.TargetApi;
import android.app.Notification;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.content.Context;
import android.content.ContextWrapper;
import android.net.Uri;
import android.os.Build;

import com.example.khoavx.accessoriceshop.R;


public class NotificationHelper extends ContextWrapper {
    private static final String EDMT_CHANNEL_ID = "com.example.vantran.drinkshop.DrinkShop";
    private static final String EMDT_CHANNEL_NAME = "Shop Accessories";

    private NotificationManager notificationManager;

    public NotificationHelper(Context base){
        super(base);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O){
            createChannel();
        }
    }

    @TargetApi(Build.VERSION_CODES.O)
    private void createChannel() {
        NotificationChannel channel = new NotificationChannel(EDMT_CHANNEL_ID, EMDT_CHANNEL_NAME,
                NotificationManager.IMPORTANCE_DEFAULT);
        channel.enableLights(false);
        channel.enableVibration(true);
        channel.setLockscreenVisibility(Notification.VISIBILITY_PRIVATE);
        getManager().createNotificationChannel(channel);
    }

    public NotificationManager getManager() {
        if (notificationManager == null)
            notificationManager = (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);
        return notificationManager;
    }
    @TargetApi(Build.VERSION_CODES.O)
    public Notification.Builder getDrinkShopNotication(String title, String message, Uri soundUri){
        return new Notification.Builder(getApplicationContext(),EDMT_CHANNEL_ID)
                .setContentTitle(title)
                .setContentText(message)
                .setSmallIcon(R.mipmap.ic_launcher)
                .setSound(soundUri)
                .setAutoCancel(true);
    }
}
