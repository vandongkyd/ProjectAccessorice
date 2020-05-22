package com.example.khoavx.accessoriceshop;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.ButtonBarLayout;
import android.text.Html;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.cepheuen.elegantnumberbutton.view.ElegantNumberButton;
import com.daimajia.slider.library.SliderLayout;
import com.daimajia.slider.library.SliderTypes.BaseSliderView;
import com.daimajia.slider.library.SliderTypes.TextSliderView;
import com.example.khoavx.accessoriceshop.Database.ModelDB.Cart;
import com.example.khoavx.accessoriceshop.Database.ModelDB.Favorite;
import com.example.khoavx.accessoriceshop.Model.Product;
import com.example.khoavx.accessoriceshop.Model.ProductImage;
import com.example.khoavx.accessoriceshop.Retrofit.ICallShopAPI;
import com.example.khoavx.accessoriceshop.Utils.Common;
import com.google.gson.Gson;
import com.squareup.picasso.Picasso;

import java.util.HashMap;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.functions.Consumer;
import io.reactivex.schedulers.Schedulers;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ProductDetailActivity extends AppCompatActivity {

//    @BindView(R.id.img_drink)
//    ImageView img_drink;
    @BindView(R.id.t_name_drink)
    TextView t_name_drink;
    @BindView(R.id.tv_drinkdetail)
    TextView tv_drinkdetail;
    @BindView(R.id.t_price)
    TextView t_price;
    @BindView(R.id.t_category)
    TextView t_category;
    @BindView(R.id.t_productcode)
    TextView t_productcode;
    @BindView(R.id.t_discount)
    TextView t_discount;
    @BindView(R.id.tv_description)
    TextView tv_description;
    @BindView(R.id.t_quality)
    TextView t_quality;
    @BindView(R.id.btn_cart)
    ImageView btn_cart;
    @BindView(R.id.btn_like)
    ImageView btn_like;
    @BindView(R.id.btn_back)
    ButtonBarLayout btn_back;
    @BindView(R.id.slider)
    SliderLayout slider_layout;
    @BindView(R.id.cart_badge)
    TextView cart_badge;
    @BindView(R.id.icon_card)
    ImageView icon_card;

    CompositeDisposable compositeDisposable = new CompositeDisposable();
    ICallShopAPI iCallShopAPI;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_product_detail);
        ButterKnife.bind(this);
        iCallShopAPI = Common.callAPI();
        getProductImage(Common.currentProduct.getId());

        showProductImage(Common.currentProduct.getId());

        btn_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
//
//        // set Favorite
//
//        if (Common.favoriteRepository.isFavoriteItems(Integer.valueOf(drink.getID())) == 1){
//            btn_like.setImageResource(R.drawable.ic_favorite_white);
//        }else {
//            btn_like.setImageResource(R.drawable.ic_favorite_border_white);
//        }
//
        btn_like.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (Common.currentCustomer != null) {
                    if (Common.favoriteRepository.isFavoriteItems(Integer.valueOf(Common.currentProduct.getId())) != 1) {
                        addOrRemoveToFavorite(Common.currentProduct, true);
                        btn_like.setImageResource(R.drawable.ic_favorite_white);
                    } else {
                        addOrRemoveToFavorite(Common.currentProduct, false);
                        btn_like.setImageResource(R.drawable.ic_favorite_border_white);
                    }
                }else {
                    Common.PopupMessages("Like", ProductDetailActivity.this);
                }
            }
        });
//
        btn_cart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                showDialogAddToCart(Common.currentProduct);
            }
        });

        if (Common.currentCustomer != null) {
            icon_card.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    startActivity(new Intent(ProductDetailActivity.this, CartActivity.class));
                }
            });
            updateCartCount();
        }
    }

    private void showProductImage(String id){
        iCallShopAPI.getProductId(id)
                .enqueue(new Callback<Product>() {
                    @Override
                    public void onResponse(Call<Product> call, Response<Product> response) {
                        Product product = response.body();
                        double price = 0;
                        if (Integer.valueOf(product.getPercent_reduction()) > 0){
                            price = (Double.valueOf(product.getProduct_price()) - (Double.valueOf(product.getProduct_price()) * Double.valueOf(product.getPercent_reduction())) / 100);
                        }else {
                            price = Double.valueOf(product.getProduct_price());
                        }
                        t_price.setText(Common.formatNumber(price) + " VND");
                        t_name_drink.setText(product.getProduct_name());
                        t_discount.setText(product.getDiscount_name());
                        t_category.setText(product.getCategory_name());
                        t_productcode.setText(product.getProduct_code());
                        t_quality.setText(product.getProduct_quality());
                        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.N) {
                            tv_drinkdetail.setText(Html.fromHtml(product.getProduct_detail(), Html.FROM_HTML_MODE_LEGACY));
                            tv_description.setText(Html.fromHtml(product.getProduct_description(), Html.FROM_HTML_MODE_LEGACY));
                        } else {
                            tv_drinkdetail.setText(Html.fromHtml(product.getProduct_detail()));
                            tv_description.setText(Html.fromHtml(product.getProduct_description()));
                        }
                    }

                    @Override
                    public void onFailure(Call<Product> call, Throwable t) {
                    }
                });
    }

    private void getProductImage(String id){
        compositeDisposable.add(iCallShopAPI.getProductImages(id)
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Consumer<List<ProductImage>>() {
                    @Override
                    public void accept(List<ProductImage> banners) throws Exception {
                        dislayImage(banners);
                    }
                })
        );
    }

    private void dislayImage(List<ProductImage> banners) {
        HashMap<String, String> bannerMap = new HashMap<>();
        for (ProductImage banner : banners){
            bannerMap.put(banner.getSort_no(), Common.BASE_URL_IMAGE_API + banner.getFile_name());
        }
        for (String name : bannerMap.keySet()){
            TextSliderView textSliderView = new TextSliderView(ProductDetailActivity.this);
            textSliderView.image(bannerMap.get(name))
                    .setScaleType(BaseSliderView.ScaleType.Fit);
            slider_layout.addSlider(textSliderView);
        }

    }


    private void addOrRemoveToFavorite(Product drink,boolean isFavorite) {
        if (Common.currentCustomer != null) {
            Favorite favorite = new Favorite();
            favorite.id = Integer.valueOf(drink.getId());
            favorite.images = drink.getFile_name();
            favorite.name = drink.getProduct_name();
            favorite.price = Double.valueOf(drink.getProduct_price());
            favorite.productId = Integer.valueOf(drink.getId());
            favorite.phone = Common.currentCustomer.getPhone();
            if (isFavorite) {
                Common.favoriteRepository.insertToFavorite(favorite);
            } else {
                Common.favoriteRepository.deleteFavoriteItems(favorite);
            }
        }

    }

    private void showDialogAddToCart(Product drink) {
        AlertDialog.Builder builder = new AlertDialog.Builder(ProductDetailActivity.this);
        View itemView = LayoutInflater.from(ProductDetailActivity.this).inflate(R.layout.add_to_cart_layout, null);


        ImageView img_cart = (ImageView) itemView.findViewById(R.id.img_cart);
        ElegantNumberButton btn_number = (ElegantNumberButton) itemView.findViewById(R.id.t_count);
        TextView t_name_cart = (TextView) itemView.findViewById(R.id.t_name_cart);

        Common.sizeOfCup = 0;
        Common.sugar = 100;
        Common.ice = 100;


        Picasso.with(ProductDetailActivity.this).load(Common.BASE_URL_IMAGE_API + drink.getFile_name()).into(img_cart);
        t_name_cart.setText(drink.getProduct_name());

        builder.setView(itemView);
        builder.setPositiveButton("CANCEL", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.cancel();
            }
        });
        builder.setNegativeButton("ADD TO CART", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                showDialogConfrim(drink, btn_number.getNumber());
                dialog.dismiss();
            }
        });
        builder.show();


    }

    private void showDialogConfrim(Product drink, String number) {
        AlertDialog.Builder builder = new AlertDialog.Builder(ProductDetailActivity.this);
        View itemView = LayoutInflater.from(ProductDetailActivity.this).inflate(R.layout.dialog_confrim_addcart, null);

        ImageView img_cart = (ImageView) itemView.findViewById(R.id.img_drink);
        TextView t_name_cart = (TextView) itemView.findViewById(R.id.t_name_cart);
        TextView t_price = (TextView) itemView.findViewById(R.id.t_price);

        Picasso.with(ProductDetailActivity.this).load(Common.BASE_URL_IMAGE_API + drink.getFile_name()).into(img_cart);
        t_name_cart.setText(new StringBuilder(drink.getProduct_name()).append("x")
                .append(number).toString()

        );

        double price = (Double.valueOf(drink.getProduct_price()));

        double finalPrice = Math.round(price);
        t_price.setText(Common.formatNumber(finalPrice) + " VND");
        builder.setPositiveButton("CANCEL", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });
        builder.setNegativeButton("CONFIRM", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
                try {
                    if (Common.currentCustomer != null) {
                        // Add to SQLite
                        // Create new Cart Item
                        Cart cartItem = new Cart();
                        cartItem.name = drink.getProduct_name();
                        cartItem.product_id = drink.getId();
                        cartItem.quality_item = Integer.valueOf(number);
                        cartItem.amount = finalPrice;
                        cartItem.images = drink.getFile_name();

                        //Add to DB
                        Common.cartRepository.insertToCart(cartItem);

                        Log.d("EDMT_DEBUG", new Gson().toJson(cartItem));

                        Toast.makeText(ProductDetailActivity.this, "Save item to cart success", Toast.LENGTH_SHORT).show();

                    }else {
                        Common.PopupMessages("Cart", ProductDetailActivity.this);
                    }
                }catch (Exception e){
                    Toast.makeText(ProductDetailActivity.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }
        });
        builder.setView(itemView);
        builder.show();
    }

    private void updateCartCount() {
        if (cart_badge == null) return;
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                if (Common.cartRepository.countCartItems() == 0){
                    cart_badge.setVisibility(View.INVISIBLE);
                }else {
                    cart_badge.setVisibility(View.VISIBLE);
                    cart_badge.setText(String.valueOf(Common.cartRepository.countCartItems()));
                }
            }
        });
    }
}
