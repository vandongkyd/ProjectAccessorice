<?php

namespace App\ServiceImpl\Admin;


use App\Model\ShopInfo;
use App\Service\Admin\ShopInfoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopInfoServiceImpl implements ShopInfoService
{

    function list()
    {
        $shops = ShopInfo::select('*')
            ->where('del_flg','=', ShopInfo::DEL_FLG)
            ->get();

        return $shops;
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

        $shop = new ShopInfo();
        $shop->shop_name = $req->get('shop_name');
        $shop->shop_address = $req->get('shop_address');
        $shop->shop_phone = $req->get('shop_phone');
        $shop->shop_status = $req->get('shop_status');
        $shop->created = time();

        if ($shop->save()){
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

        $shop = $this->fetchById($req->get('id'));
        $shop->shop_name = $req->get('shop_name');
        $shop->shop_address = $req->get('shop_address');
        $shop->shop_phone = $req->get('shop_phone');
        $shop->shop_status = $req->get('shop_status');
        $shop->updated = time();

        if ($shop->save()){
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
        $shop = $this->fetchById($req->get('id'));
        $shop->del_flg = ShopInfo::DELETE;
        if ($shop->save()){
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
        return ShopInfo::findOrFail($id);
    }

    function validation(Request $req)
    {
        $validation = Validator::make($req->all(), [
            'shop_name' => [
                'required','max:50',
            ],
            'shop_address' => [
                'required','max:255',
            ],
            'shop_phone' => [
                'required','digits_between:9,11','numeric',
            ],
        ]);

        return $validation;
    }
}