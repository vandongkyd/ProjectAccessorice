<?php

namespace App\Http\Controllers;

use App\Model\Brand;
use App\Model\Discount;
use App\Model\ProductCategory;
use App\Model\ShopInfo;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getDiscount(){
        return Discount::where('del_flg', '=', Discount::DEL_FLG)
            ->where('discount_status', '=', Discount::ACTIVE)
            ->get();
    }

    public function getShop(){
        return ShopInfo::where('del_flg','=', ShopInfo::DEL_FLG)->get();
    }

    public function getBrand(){
        return Brand::where('del_flg', '=',  Brand::DEL_FLG)
            ->where('brand_status', '=', Brand::PUBLIC)
            ->get();
    }

    public function getProductCategory(){
        return ProductCategory::where('del_flg', '=',  ProductCategory::DEL_FLG)
            ->where('category_status', '=', ProductCategory::PUBLIC)
            ->get();
    }
}
