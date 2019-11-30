<?php

namespace App\ServiceImpl\Admin;


use App\Model\ShipType;
use App\Service\Admin\ShipTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipTypeServiceImpl implements ShipTypeService
{

    function list()
    {
        $ships = ShipType::select('*')
            ->where('del_flg','=', ShipType::DEL_FLG)
            ->get();
        return $ships;
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

        $ship = new ShipType();
        $ship->ship_name = $req->get('ship_name');
        $ship->ship_price = $req->get('ship_price');
        $ship->ship_status = $req->get('ship_status');
        $ship->created = time();

        if ($ship->save()){
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

        $ship = $this->fetchById($req->get('id'));
        $ship->ship_name = $req->get('ship_name');
        $ship->ship_price = $req->get('ship_price');
        $ship->ship_status = $req->get('ship_status');
        $ship->updated = time();

        if ($ship->save()){
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
        $ship = $this->fetchById($req->get('id'));
        $ship->del_flg = ShipType::DELETE;
        if ($ship->save()){
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
        return ShipType::findOrFail($id);
    }

    function validation(Request $req)
    {
        $validation = Validator::make($req->all(), [
            'ship_name' => [
                'required','max:50',
            ],
            'ship_price' => [
                'required','max:50','regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            ],
        ]);

        return $validation;
    }
}