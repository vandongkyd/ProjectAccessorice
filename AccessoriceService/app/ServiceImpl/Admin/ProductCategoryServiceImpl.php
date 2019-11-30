<?php

namespace App\ServiceImpl\Admin;


use App\Model\ProductCategory;
use App\Service\Admin\ProductCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductCategoryServiceImpl implements ProductCategoryService
{

    function list()
    {
        $categories = ProductCategory::select('t_product_category.*',
            't_brand.brand_name',
            't_discount.discount_name')
            ->leftJoin('t_brand','t_brand.id','=', 't_product_category.brand_id')
            ->leftJoin('t_discount','t_discount.id','=', 't_product_category.discount_id')
            ->where('t_product_category.del_flg', '=', ProductCategory::DEL_FLG)
            ->get();

        return $categories;
    }

    function add(Request $req)
    {
        $validation = $this->validation($req);

        if ($validation->fails()){
            return [
                "status" => false,
                "validate" => $validation
            ];
        }
        $category = new ProductCategory();
        $category->category_name = $req->get('category_name');
        $category->brand_id = $req->get('brand');
        $category->discount_id = $req->get('discount');
        $category->category_status = $req->get('category_status');
        $category->created = time();

        if ($category->save()){
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
        $validation = $this->validation($req);

        if ($validation->fails()){
            return [
                "status" => false,
                "validate" => $validation
            ];
        }

        $category = $this->fetchById($req->get('id'));
        $category->category_name = $req->get('category_name');
        $category->brand_id = $req->get('brand');
        $category->discount_id = $req->get('discount');
        $category->category_status = $req->get('category_status');
        $category->updated = time();

        if ($category->save()){
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
        $category = $this->fetchById($req->get('id'));
        $category->del_flg = ProductCategory::DELETE;

        if ($category->save()){
            return [
               "status" => true,
            ];
        }

        return [
            "status" => false
        ];
    }

    function fetchById($id)
    {
       return ProductCategory::findOrFail($id);
    }

    function validation(Request $req)
    {
        $validation = Validator::make($req->all(), [
            'category_name' => [
                'required','max:50',
            ],
            'brand' => [
                'required'
            ],
            'discount' => [
                'required'
            ],
        ]);
        return $validation;
    }
}