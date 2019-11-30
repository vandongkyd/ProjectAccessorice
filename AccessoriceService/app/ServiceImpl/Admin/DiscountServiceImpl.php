<?php

namespace App\ServiceImpl\Admin;


use App\Model\Discount;
use App\Service\Admin\DiscountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountServiceImpl implements DiscountService
{

    function list()
    {
        $discounts = Discount::select('*')
            ->where('del_flg', '=', Discount::DEL_FLG)
            ->get();

        return $discounts;
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
        $discount = new Discount();
        $discount->discount_name = $req->get('discount_name');
        $discount->percent_reduction = $req->get('percent_reduction');
        $discount->gift_code = $req->get('gift_code');
        $discount->discount_status = $req->get('discount_status');
        $discount->created = time();

        if ($discount->save()){
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
        $discount = $this->fetchById($req->get('id'));
        $discount->discount_name = $req->get('discount_name');
        $discount->percent_reduction = $req->get('percent_reduction');
        $discount->gift_code = $req->get('gift_code');
        $discount->discount_status = $req->get('discount_status');
        $discount->updated = time();

        if ($discount->save()){
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
        $discount = $this->fetchById($req->get('id'));
        $discount->del_flg = Discount::DELETE;

        if ($discount->save()){
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
        return Discount::findOrFail($id);
    }

    function validation(Request $req)
    {
        $validation = Validator::make($req->all(), [
            'discount_name' => [
                'required','max:50',
            ],
            'percent_reduction' => [
                'required','max:50',
            ],
            'gift_code' => [
                'required','max:50',
            ],
        ]);

        return $validation;
    }
}