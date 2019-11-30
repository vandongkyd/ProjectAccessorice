<?php

namespace App\ServiceImpl\Admin;




use App\Model\Banner;
use App\Model\Product;
use App\Model\ProductCategory;
use App\Service\Admin\BannerService;
use Illuminate\Support\Facades\DB;
use Respect\Validation\Validator as V;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerServiceImpl implements BannerService
{
    function list()
    {
        $banners = Banner::select('*')
            ->where('del_flg','=', Banner::DEL_FLG)
            ->get();
        return $banners;
    }

    function add(Request $req)
    {
        $validation = $this->validation($req,Banner::ADD);

        if ($validation->fails()){
            return [
                "status" => false,
                "validate" => $validation
            ];
        }
        $file_upload = $req->file('banner_image');
        $new_name = uniqid() . '_' . time() . '.' . $file_upload->getClientOriginalExtension();
        $file_upload->move(public_path('upload'), $new_name);
        $banner = new Banner();
        $banner->banner_name = $req->get('banner_name');
        $banner->banner_img = $new_name;
        $banner->category_id = $req->get('category');
        $banner->product_id = $req->get('product');
        $banner->banner_description = $req->get('banner_description');
        $banner->banner_date_start = strtotime($req->get('date_start'));
        $banner->banner_date_end = strtotime($req->get('date_end'));
        $banner->sort_no = ($this->fetchSortBanner()['sort_no'] + 1);
        $banner->banner_status = $req->get('banner_status');
        $banner->created = time();
        if ($banner->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];

    }

    function edit(Request $req)
    {
        $validation = $this->validation($req,Banner::EDIT);
        if ($validation->fails()){
            return [
                "status" => false,
                "validate" => $validation
            ];
        }
        $banner = $this->fetchById($req->get('id'));
        $file_upload = $req->file('banner_image');
        if (isset($file_upload)) {
            $new_name = uniqid() . '_' . time() . '.' . $file_upload->getClientOriginalExtension();
            $file_upload->move(public_path('upload'), $new_name);
            $banner->banner_img = $new_name;
        }
        $banner->banner_name = $req->get('banner_name');
        $banner->category_id = $req->get('category');
        $banner->product_id = $req->get('product');
        $banner->banner_description = $req->get('banner_description');
        $banner->banner_status = $req->get('banner_status');
        $banner->banner_date_start = strtotime($req->get('date_start'));
        $banner->banner_date_end = strtotime($req->get('date_end'));
        $banner->updated = time();
        if ($banner->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function delete(Request $req)
    {
        $banner = $this->fetchById($req->get('id'));
        $banner->del_flg = Banner::DELETE;
        if ($banner->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function getProduct()
    {
        $products = Product::select('id','product_name')
            ->where('product_status', '=', Product::PUBLIC)
            ->where('del_flg', '=', Product::DEL_FLG)
            ->get();
        return $products;
    }

    function getProductCategory()
    {
        $categories = ProductCategory::select('id','category_name')
            ->where('category_status', '=', ProductCategory::PUBLIC)
            ->where('del_flg', '=', ProductCategory::DEL_FLG)
            ->get();
        return $categories;
    }

    function fetchById($id)
    {
        return Banner::findOrFail($id);
    }

    function fetchSortBanner()
    {
        return Banner::select('sort_no')->orderBy('sort_no' , 'desc')->first();
    }

    function validation(Request $req, $mod)
    {
        $validate_array = [
            'banner_name' => 'required|max:50',
            'product' => [
                function ($attribute, $value, $fail) {
                    $request = Request();
                    if (empty($request->category) && empty($request->product)) {
                        $fail(trans('validation.required'));
                    };
                }
            ],
            'category' => [
                function ($attribute, $value, $fail) {
                    $request = Request();
                    if (empty($request->category) && empty($request->product)) {
                        $fail(trans('validation.required'));
                    };
                }
            ],
        ];

        if (!empty($req->date_start) && !empty($req->date_end)){
            $validate_array['date_end'] = 'date|after_or_equal:date_start';
        }

        if ($mod == Banner::ADD){
            $validate_array['banner_image'] = 'required|max:2048';
        }else{
            $validate_array['banner_image'] = 'max:2048';
        }
        $validation = Validator::make($req->all(), $validate_array);
        return $validation;
    }
}