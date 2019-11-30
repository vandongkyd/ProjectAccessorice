<?php

namespace App\ServiceImpl\Admin;


use App\Model\Discount;
use App\Model\Product;
use App\Model\ProductCategory;
use App\Model\ProductImage;
use App\Service\Admin\ProductService;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductServiceImpl implements ProductService
{

    function list()
    {
        $products = Product::join('t_product_image', 't_product_image.product_id', '=', 't_product.id')
            ->join('t_product_category', 't_product_category.id', '=', 't_product.category_id')
            ->join('t_discount', 't_discount.id', '=', 't_product.discount_id')
            ->select('t_product.*', 't_product_image.file_name', 't_product_category.category_name', 't_discount.discount_name')
            ->where('t_product.del_flg', '=', Product::DEL_FLG)
            ->where('t_product_category.del_flg', '=', ProductCategory::DEL_FLG)
            ->where('t_discount.del_flg', '=', Discount::DEL_FLG)
            ->groupBy('t_product_image.product_id')
            ->get();
        return $products;
    }


    function listImages($id)
    {
        return $product_images = ProductImage::where('product_id', '=', $id)->get();
    }

    function add(Request $req)
    {
        $validation = $this->validation($req);

        if ($validation->fails()) {
            return [
                "status" => false,
                "validate" => $validation
            ];
        }
        $description = $req->get('product_description');
        $dom = new DOMDocument();
        $dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $tagimg = $dom->getElementsByTagName('img');
        foreach ($tagimg as $img) {
            $data = $img->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $image_name = uniqid() . '_' . time() . '.png';
            $path = public_path('upload') . '/' . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', url('/upload/') . '/' . $image_name);
        }

        $product = new Product();
        $product->product_code = $req->get('product_code');
        $product->product_name = $req->get('product_name');
        $product->category_id = $req->get('category');
        $product->product_price = $req->get('product_price');
        $product->product_quality = $req->get('product_quality');
        $product->product_description = $dom->saveHTML();
        $product->product_detail = $req->get('product_detail');
        $product->product_status = $req->get('product_status');
        $product->product_date_start = strtotime($req->get('date_start'));
        $product->product_date_end = strtotime($req->get('date_end'));
        $product->discount_id = $req->get('discount');
        $product->created = time();

        if ($product->save()) {
            $images_product = $req->get('images_product');
            for ($i = 0; $i < count($images_product); $i++) {
                $product_image = new ProductImage();
                $product_image->product_id = $product->id;
                $product_image->file_name = $images_product[$i];
                $product_image->sort_no = $i;
                $product_image->save();

                $this->moveAndRemove($images_product[$i]);
            }

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

        if ($validation->fails()) {
            return [
                "status" => false,
                "validate" => $validation
            ];
        }

        $description = $req->get('product_description');
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $tagimg = $dom->getElementsByTagName('img');
        foreach ($tagimg as $img) {
            $data = $img->getAttribute('src');
            if (!strstr($data, url('/upload/'))) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $image_name = rand() . time() . '.png';
                $path = public_path('upload') . '/' . $image_name;
                file_put_contents($path, $data);
                $img->removeAttribute('src');
                $img->setAttribute('src', url('/upload/') . '/' . $image_name);
            }
        }

        $product = $this->fetchById($req->get('id'));
        $product->product_code = $req->get('product_code');
        $product->product_name = $req->get('product_name');
        $product->category_id = $req->get('category');
        $product->product_price = $req->get('product_price');
        $product->product_quality = $req->get('product_quality');
        $product->product_description = $dom->saveHTML();
        $product->product_detail = $req->get('product_detail');
        $product->product_status = $req->get('product_status');
        $product->product_date_start = strtotime($req->get('date_start'));
        $product->product_date_end = strtotime($req->get('date_end'));
        $product->discount_id = $req->get('discount');
        $product->updated = time();

        if ($product->save()) {
            $sort_no = $req->get('sort_no') + 1;
            $images_product = $req->get('images_product');
            for ($i = 0; $i < count($images_product); $i++) {
                $new_dir = public_path('upload');
                $new_path = $new_dir . '/' . $images_product[$i];
                if (!file_exists($new_path)) {
                    $product_image = new ProductImage();
                    $product_image->product_id = $product->id;
                    $product_image->file_name = $images_product[$i];
                    $product_image->sort_no = $sort_no + $i;
                    $product_image->save();

                    $this->moveAndRemove($images_product[$i]);
                }
            }

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
        $product = $this->fetchById($req->get('id'));
        $product->del_flg = Product::DELETE;

        if ($product->save()) {
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
        return Product::findOrFail($id);
    }

    function fetchImageById($id)
    {
        return ProductImage::findOrFail($id);
    }

    function fetchDetailById($id)
    {
        $products = Product::join('t_product_category', 't_product_category.id', '=', 't_product.category_id')
            ->join('t_discount', 't_discount.id', '=', 't_product.discount_id')
            ->select('t_product.*', 't_product_category.category_name', 't_discount.discount_name')
            ->where('t_product.del_flg', '=', Product::DEL_FLG)
            ->where('t_product_category.del_flg', '=', ProductCategory::DEL_FLG)
            ->where('t_discount.del_flg', '=', Discount::DEL_FLG)
            ->where('t_product.id', '=', $id)
            ->first();
        return $products;
    }

    function deleteImage($file_name)
    {
        return ProductImage::where('file_name', $file_name)->delete();
    }

    function moveAndRemove($file_name)
    {
        $new_dir = public_path('upload');
        $old_dir = public_path('upload_temp');
        $new_path = $new_dir . '/' . $file_name;
        $old_path = $old_dir . '/' . $file_name;
        if (file_exists($old_path)) {
            link($old_path, $new_path);
            unlink($old_path);
        }
    }

    function validation(Request $req)
    {
        $validate_array = [
            'product_code' => [
                'required',
                function ($attribute, $value, $fail) {
                    $request = Request();
                    $checkExits = DB::table('t_product')
                        ->where('t_product.product_code', '=', $value)
                        ->where('t_product.del_flg', '=', Product::DEL_FLG);
                    if (isset($request->id)) {
                        $account = Product::findOrFail($request->id);
                        $checkExits = $checkExits->where('t_product.id', '<>', $account->id)->get()->count();
                    } else {
                        $checkExits = $checkExits->get()->count();
                    }
                    if ($checkExits > 0) {
                        $fail(trans('validation.unique'));
                    };
                }
            ],

            'category' => 'required',
            'product_price' => 'required|numeric|digits_between:1,10',
            'product_quality' => 'required|integer|between:1,1000',
            'discount' => 'required',
            'product_name' => 'required|max:50|min:3',
            'product_description' => 'required',
            'product_detail' => 'required',
        ];
        $images_product = $req->get('images_product');
        if (count($images_product) == 0) {
            $validate_array['upload_file'] = 'required';
        }
        if (!empty($req->date_start) && !empty($req->date_end)){
            $validate_array['date_end'] = 'date|after_or_equal:date_start';
        }
        $validation = Validator::make($req->all(), $validate_array);
        return $validation;
    }
}