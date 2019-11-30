<?php

namespace App\Providers;

use App\Service\Admin\BannerService;
use App\Service\Admin\BrandService;
use App\Service\Admin\CustomerService;
use App\Service\Admin\DashboardService;
use App\Service\Admin\DiscountService;
use App\Service\Admin\InvoiceDetailService;
use App\Service\Admin\InvoiceService;
use App\Service\Admin\ProductService;
use App\Service\Admin\ProductCategoryService;
use App\Service\Admin\ShipTypeService;
use App\Service\Admin\ShopInfoService;
use App\Service\Admin\UserService;
use App\Service\Shop\HomeService;
use App\ServiceImpl\Admin\DashboardServiceImpl;
use App\ServiceImpl\Admin\BannerServiceImpl;
use App\ServiceImpl\Admin\BrandServiceImpl;
use App\ServiceImpl\Admin\CustomerServiceImpl;
use App\ServiceImpl\Admin\DiscountServiceImpl;
use App\ServiceImpl\Admin\InvoiceDetailServiceImpl;
use App\ServiceImpl\Admin\InvoiceServiceImpl;
use App\ServiceImpl\Admin\ProductServiceImpl;
use App\ServiceImpl\Admin\ProductCategoryServiceImpl;
use App\ServiceImpl\Admin\ShipTypeServiceImpl;
use App\ServiceImpl\Admin\ShopInfoServiceImpl;
use App\ServiceImpl\Admin\UserServiceImpl;
use App\ServiceImpl\Shop\HomeServiceImpl;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Admin

        $this->app->singleton(BannerService::class, function (){
           return new BannerServiceImpl();
        });

        $this->app->singleton(BrandService::class, function (){
            return new BrandServiceImpl();
        });

        $this->app->singleton(CustomerService::class, function (){
           return new CustomerServiceImpl();
        });

        $this->app->singleton(DiscountService::class, function (){
            return new DiscountServiceImpl();
        });

        $this->app->singleton(InvoiceService::class, function (){
            return new InvoiceServiceImpl();
        });

        $this->app->singleton(InvoiceDetailService::class, function (){
            return new InvoiceDetailServiceImpl();
        });

        $this->app->singleton(ProductService::class, function (){
            return new ProductServiceImpl();
        });

        $this->app->singleton(ProductCategoryService::class, function (){
            return new ProductCategoryServiceImpl();
        });

        $this->app->singleton(ShipTypeService::class, function (){
            return new ShipTypeServiceImpl();
        });

        $this->app->singleton(ShopInfoService::class, function (){
            return new ShopInfoServiceImpl();
        });

        $this->app->singleton(UserService::class, function (){
            return new UserServiceImpl();
        });

        $this->app->singleton(DashboardService::class, function (){
            return new DashboardServiceImpl();
        });


        // Shop

        $this->app->singleton(HomeService::class, function (){
            return new HomeServiceImpl();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
