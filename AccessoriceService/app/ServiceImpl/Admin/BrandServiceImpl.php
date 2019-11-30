<?php

namespace App\ServiceImpl\Admin;



use App\Model\Brand;
use App\Service\Admin\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandServiceImpl implements BrandService
{

    function list()
    {
        $brand = Brand::select('*')
            ->where('del_flg','=', Brand::DEL_FLG)
            ->get();
        return $brand;
    }

    function add(Request $req)
    {
        $validation = $this->validation($req, Brand::ADD);

        if ($validation->fails()){
            return [
                "status" => false,
                "validate" => $validation
            ];
        }
        $file_upload = $req->file('brand_image');
        $new_name = uniqid() . '_' . time() . '.' . $file_upload->getClientOriginalExtension();
        $file_upload->move(public_path('upload'), $new_name);
        $brand = new Brand();
        $brand->brand_name = $req->get('brand_name');
        $brand->brand_img = $new_name;
        $brand->discount_id = $req->get('discount_id');
        $brand->brand_status = $req->get('brand_status');
        $brand->created = time();

        if ($brand->save()){
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
        $validation = $this->validation($req,Brand::EDIT);
        if ($validation->fails()){
            return [
                "status" => false,
                "validate" => $validation
            ];
        }
        $brand = $this->fetchById($req->get('id'));
        $file_upload = $req->file('brand_image');
        if (isset($file_upload)) {
            $new_name = uniqid() . '_' . time() . '.' . $file_upload->getClientOriginalExtension();
            $file_upload->move(public_path('upload'), $new_name);
            $brand->brand_img = $new_name;
        }
        $brand->brand_name = $req->get('brand_name');
        $brand->discount_id = $req->get('discount_id');
        $brand->brand_status = $req->get('brand_status');
        $brand->updated = time();
        if ($brand->save()){
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
        $brand = $this->fetchById($req->get('id'));
        $brand->del_flg = Brand::DELETE;
        if ($brand->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function fetchById($id)
    {
        return Brand::findOrFail($id);
    }

    function validation(Request $req, $mod)
    {
        $validate_array = [
            'brand_name' => 'required|max:50',
            'discount_id' => 'required',
        ];
        if ($mod == Brand::ADD){
            $validate_array['brand_image'] = 'required|max:2048';
        }else{
            $validate_array['brand_image'] = 'max:2048';
        }
        $validation = Validator::make($req->all(), $validate_array);
        return $validation;
    }
}