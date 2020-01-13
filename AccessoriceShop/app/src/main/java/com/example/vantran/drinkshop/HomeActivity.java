package com.example.vantran.drinkshop;

import android.app.Activity;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.daimajia.slider.library.SliderLayout;
import com.daimajia.slider.library.SliderTypes.BaseSliderView;
import com.daimajia.slider.library.SliderTypes.TextSliderView;
import com.example.vantran.drinkshop.Apdater.BrandAdapter;
import com.example.vantran.drinkshop.Apdater.CategoryAdapter;
import com.example.vantran.drinkshop.Database.DataSource.CartRepository;
import com.example.vantran.drinkshop.Database.DataSource.FavoriteRepository;
import com.example.vantran.drinkshop.Database.Local.CartDataSource;
import com.example.vantran.drinkshop.Database.Local.EMDTRoomDatabase;
import com.example.vantran.drinkshop.Database.Local.FavoriteDataSource;
import com.example.vantran.drinkshop.Model.Banner;
import com.example.vantran.drinkshop.Model.Brand;
import com.example.vantran.drinkshop.Model.Category;
import com.example.vantran.drinkshop.Model.CheckUserResponse;
import com.example.vantran.drinkshop.Model.Drink;
import com.example.vantran.drinkshop.Model.Store;
import com.example.vantran.drinkshop.Model.Token;
import com.example.vantran.drinkshop.Model.User;
import com.example.vantran.drinkshop.Retrofit.ICallShopAPI;
import com.example.vantran.drinkshop.Retrofit.IDrinkShopAPI;
import com.example.vantran.drinkshop.Utils.Common;
import com.example.vantran.drinkshop.Utils.ProgressRequestBody;
import com.example.vantran.drinkshop.Utils.UploadCallBack;
import com.facebook.accountkit.Account;
import com.facebook.accountkit.AccountKit;
import com.facebook.accountkit.AccountKitCallback;
import com.facebook.accountkit.AccountKitError;
import com.google.android.gms.tasks.Continuation;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.InstanceIdResult;
import com.google.firebase.storage.FirebaseStorage;
import com.google.firebase.storage.StorageReference;
import com.google.firebase.storage.UploadTask;
import com.ipaulpro.afilechooser.utils.FileUtils;
import com.nex3z.notificationbadge.NotificationBadge;
import com.squareup.picasso.Picasso;

import java.io.File;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.concurrent.TimeUnit;

import de.hdodenhof.circleimageview.CircleImageView;
import dmax.dialog.SpotsDialog;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;
import okhttp3.MultipartBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class HomeActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener, UploadCallBack {

    private static final int PICK_FILE_REQUEST = 10002;
    Uri selectFileUri;

    TextView t_name, t_phone;
    SliderLayout slider_layout;
    IDrinkShopAPI iDrinkShopAPI;
    ICallShopAPI iCallShopAPI;
    RecyclerView rv_menu;
    NotificationBadge badge;
    ImageView icon_card;
    CircleImageView img_avtar;
    CompositeDisposable compositeDisposable = new CompositeDisposable();
    SwipeRefreshLayout swipe_to_ref;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        swipe_to_ref = (SwipeRefreshLayout)findViewById(R.id.swipe_to_ref);
        iCallShopAPI = Common.callAPI();

        slider_layout = (SliderLayout)findViewById(R.id.slider);
        rv_menu = (RecyclerView)findViewById(R.id.rv_menu);
        rv_menu.setLayoutManager(new GridLayoutManager(this,2));
        rv_menu.setHasFixedSize(true);

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        View headerView = navigationView.getHeaderView(0);
        t_name = (TextView)headerView.findViewById(R.id.t_name);
        t_phone = (TextView)headerView.findViewById(R.id.t_phone);
        img_avtar = (CircleImageView)headerView.findViewById(R.id.img_avatar);

        if (Common.currentCustomer != null) {
            img_avtar.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    chooseImage();
                }
            });
        }

        //get List Banner
        getBannerImage();
        //get Menu
        getMenu();
        //insert DB
        initDB();

        //infor user
        getInforUser();

        swipe_to_ref.post(new Runnable() {
            @Override
            public void run() {
                swipe_to_ref.setRefreshing(true);
                //get List Banner
                getBannerImage();
                //get Menu
                getMenu();
                //infor user
                getInforUser();
            }
        });
        swipe_to_ref.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                swipe_to_ref.setRefreshing(true);
                //get List Banner
                getBannerImage();
                //get Menu
                getMenu();
                //infor user
                getInforUser();
            }
        });

//        updateTokenServer();
    }

    private void getInforUser() {
        if (Common.currentCustomer != null){
            t_name.setText(Common.currentCustomer.getLast_name() + " " + Common.currentCustomer.getFirst_name());
            t_phone.setText(Common.currentCustomer.getPhone());
            if (!TextUtils.isEmpty(Common.currentCustomer.getAvatar())) {
                Picasso.with(HomeActivity.this).load(Common.BASE_URL_IMAGE_API + Common.currentCustomer.getAvatar())
                        .into(img_avtar);
            }
        }
    }


    private void chooseImage() {
        startActivityForResult(Intent.createChooser(FileUtils.createGetContentIntent(),"Select a file"),
                PICK_FILE_REQUEST);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == PICK_FILE_REQUEST){
            if (data != null){
                selectFileUri = data.getData();
                if (selectFileUri != null && !selectFileUri.getPath().isEmpty()){
                    img_avtar.setImageURI(selectFileUri);
                    uploadFile();
                }else {
                    Toast.makeText(this, "Cannot upload file", Toast.LENGTH_SHORT).show();
                }
            }
        }
    }

    private void uploadFile() {
        if (selectFileUri != null){
            File file = FileUtils.getFile(this,selectFileUri);
            String timeStamp = String.valueOf(TimeUnit.MILLISECONDS.toSeconds(System.currentTimeMillis()));
            String filename = new StringBuilder(timeStamp).append(FileUtils.getExtension(file.toString())).toString();
            ProgressRequestBody requestBody = new ProgressRequestBody(file,this);

            final MultipartBody.Part avatar = MultipartBody.Part.createFormData("avatar",filename,requestBody);

            final MultipartBody.Part customerId = MultipartBody.Part.createFormData("customerId",Common.currentCustomer.getId());

            iCallShopAPI.uploadAvatar(customerId,avatar)
                    .enqueue(new Callback<String>() {
                        @Override
                        public void onResponse(Call<String> call, Response<String> response) {
                            Toast.makeText(HomeActivity.this, "Upload Avatar Success", Toast.LENGTH_SHORT).show();
                        }

                        @Override
                        public void onFailure(Call<String> call, Throwable t) {
                            Toast.makeText(HomeActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
                        }
                    });
        }
    }

    private void initDB() {
        Common.EMDTRoomDatabase = EMDTRoomDatabase.getInstance(this);
        Common.cartRepository = CartRepository.getInstance(CartDataSource.getInstance(Common.EMDTRoomDatabase.cartDAO()));
        Common.favoriteRepository = FavoriteRepository.getInstance(FavoriteDataSource.getInstance(Common.EMDTRoomDatabase.favoriteDAO()));
    }


    private void getBannerImage(){
        compositeDisposable.add(iCallShopAPI.getBanner()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Consumer<List<Banner>>() {
                    @Override
                    public void accept(List<Banner> banners) throws Exception {
                        dislayImage(banners);
                    }
                })
        );
    }

    @Override
    protected void onDestroy() {
        compositeDisposable.dispose();
        super.onDestroy();
    }

    private void dislayImage(List<Banner> banners) {
        for (Banner banner : banners){
            TextSliderView textSliderView = new TextSliderView(HomeActivity.this);
            textSliderView.description(banner.getBanner_name())
                    .image(Common.BASE_URL_IMAGE_API + banner.getBanner_img())
                    .setScaleType(BaseSliderView.ScaleType.Fit);
            slider_layout.addSlider(textSliderView);
        }

    }

    private void getMenu(){
        compositeDisposable.add(iCallShopAPI.getBrand()
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Consumer<List<Brand>>() {
                    @Override
                    public void accept(List<Brand> brands) throws Exception {
                        displayMenu(brands);
                    }
                })
        );
    }

    private void displayMenu(List<Brand> brands) {
        BrandAdapter brandAdapter = new BrandAdapter(this,brands);
        brandAdapter.setOnItemClickListener(clickListener);
        rv_menu.setAdapter(brandAdapter);
        swipe_to_ref.setRefreshing(false);

    }

    private BrandAdapter.OnItemClickListener clickListener = new BrandAdapter.OnItemClickListener() {
        @Override
        public void onItemClicked(Brand brand) {
            Common.currentBrand = brand;
            startActivity(new Intent(HomeActivity.this, CategoryActivity.class));
        }
    };


    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            if (isBackButtonClicked) {
                super.onBackPressed();
                return;
            }
            this.isBackButtonClicked = true;
            Toast.makeText(this, "Please click Back again to exit", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.home, menu);
        View view = menu.findItem(R.id.cart_menu).getActionView();
        badge = (NotificationBadge)view.findViewById(R.id.badge);
        icon_card = (ImageView)view.findViewById(R.id.cart_icon);
        if (Common.currentCustomer != null) {
            icon_card.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    startActivity(new Intent(HomeActivity.this, CartActivity.class));
                }
            });
            updateCartCount();
        }
        return true;
    }

    private void updateCartCount() {
        if (badge == null)return;
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                if (Common.cartRepository.countCartItems() == 0){
                    badge.setVisibility(View.INVISIBLE);
                }else {
                    badge.setVisibility(View.VISIBLE);
                    badge.setText(String.valueOf(Common.cartRepository.countCartItems()));
                }
            }
        });
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.cart_menu) {
            return true;
        }
        if (id == R.id.search_menu){
            startActivity(new Intent(HomeActivity.this, SearchActivity.class));
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();
        if (id == R.id.nav_info){
            if (Common.currentCustomer != null) {
                startActivity(new Intent(HomeActivity.this, InfoActivity.class));
            }else {
                Common.PopupMessages("Information", HomeActivity.this);
            }

        }
        if (id == R.id.nav_loacation){
            startActivity(new Intent(HomeActivity.this, NearbyStoreActivity.class));
        }

        if (id == R.id.nav_exit) {
            // Handle the camera action
            Signout();
        }
        if (id == R.id.nav_favorite){
            if (Common.currentCustomer != null) {
                startActivity(new Intent(HomeActivity.this, FavoriteListActivity.class));
            }else {
                Common.PopupMessages("Features", HomeActivity.this);
            }
        }
        if (id == R.id.nav_order){
            if (Common.currentCustomer != null) {
                startActivity(new Intent(HomeActivity.this, YourOrderActivity.class));
            }else {
                Common.PopupMessages("You Order", HomeActivity.this);
            }
        }
        if (id == R.id.nav_history){
            if (Common.currentCustomer != null) {
                startActivity(new Intent(HomeActivity.this, HistoryActivity.class));
            }else {
                Common.PopupMessages("History", HomeActivity.this);
            }
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    @Override
    protected void onResume() {
        isBackButtonClicked = false;
        super.onResume();
        updateCartCount();
    }

    @Override
    public void onProgressUpdate(int pertanage) {

    }

    boolean isBackButtonClicked = false;


    public void Signout(){
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Exit Application");
        builder.setMessage("Do you want to exit this application");
        builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                AccountKit.logOut();
                Intent i = new Intent(HomeActivity.this, HomeActivity.class);
                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(i);
                finish();
            }
        });
        builder.setNegativeButton("CANCEL", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });

        builder.show();
    }


    private void updateTokenServer() {
        if (Common.currentCustomer != null) {
            FirebaseDatabase database = FirebaseDatabase.getInstance();
            DatabaseReference myRef = database.getReference("token").child(Common.currentUser.getPhone());
            myRef.removeValue();
            FirebaseInstanceId.getInstance().getInstanceId()
                    .addOnSuccessListener(new OnSuccessListener<InstanceIdResult>() {
                        @Override
                        public void onSuccess(InstanceIdResult instanceIdResult) {
                            FirebaseDatabase database = FirebaseDatabase.getInstance();
                            DatabaseReference myRef = database.getReference("token").child(Common.currentUser.getPhone());
                            Token token = new Token();
                            token.setPhone(Common.currentUser.getPhone());
                            token.setToken(instanceIdResult.getToken());
                            token.setIsServerToken("0");
                            myRef.push().setValue(token);
                        }
                    }).addOnFailureListener(new OnFailureListener() {
                @Override
                public void onFailure(@NonNull Exception e) {
                    Toast.makeText(HomeActivity.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                }
            });
        }
    }

}
