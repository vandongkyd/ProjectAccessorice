<?php

namespace App\ServiceImpl\Admin;


use App\Model\Customer;
use App\Service\Admin\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerServiceImpl implements CustomerService
{

    function list()
    {
        $customers = Customer::select('*')->where('del_flg', '=', Customer::DEL_FLG)->get();

        return $customers;
    }

    function add(Request $request)
    {
        $validation = $this->validation($request);

        if ($validation->fails()){
            return [
                "status" => false,
                "validate" => $validation
            ];
        }
        $customer = new Customer();
        $customer->first_name = $request->get('first_name');
        $customer->last_name = $request->get('last_name');
        $customer->user_name = $request->get('user_name');
        $customer->email = $request->get('email');
        $customer->phone = $request->get('phone');
        $customer->language = $request->get('language');
        $customer->address = $request->get('address');
        $customer->gender = $request->get('gender');
        $customer->status = $request->get('status');
        $customer->password = bcrypt($this->randomPassword(10));
        $customer->created = time();
        if ($customer->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function edit(Request $request)
    {
        $validation = $this->validation($request);

        if ($validation->fails()){
            return [
                "status" => false,
                "validate" => $validation
            ];
        }
        $customer = $this->fetchById($request->get('id'));
        $customer->first_name = $request->get('first_name');
        $customer->last_name = $request->get('last_name');
        $customer->user_name = $request->get('user_name');
        $customer->email = $request->get('email');
        $customer->phone = $request->get('phone');
        $customer->language = $request->get('language');
        $customer->address = $request->get('address');
        $customer->gender = $request->get('gender');
        $customer->status = $request->get('status');
        $customer->updated = time();
        if ($customer->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function delete(Request $request)
    {
        $customer = $this->fetchById($request->get('id'));
        $customer->del_flg = Customer::DELETE;

        if ($customer->save()){
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
        return Customer::findOrFail($id);
    }

    function validation(Request $req)
    {
        $validation = Validator::make($req->all(), [
            'last_name' => [
                'required','max:50','string'
            ],
            'first_name' => [
                'required','max:50','string'
            ],
            'user_name' => [
                'required','max:50',
                function ($attribute, $value, $fail) {
                    $request = Request();
                    $checkExits = DB::table('t_customer')
                        ->where('user_name', '=', $value)
                        ->where('del_flg', '=', Customer::DEL_FLG);
                    if (isset($request->id)){
                        $checkExits = $checkExits->where('id','<>', $request->id)->count();
                    }else{
                        $checkExits = $checkExits->count();
                    }
                    if ($checkExits > 0) {
                        $fail(trans('validation.unique'));
                    };
                }
            ],
            'email' => [
                'required','max:255','email',
                function ($attribute, $value, $fail) {
                    $request = Request();
                    $checkExits = DB::table('t_customer')
                        ->where('email', '=', $value)
                        ->where('del_flg', '=', Customer::DEL_FLG);
                    if (isset($request->id)){
                        $checkExits = $checkExits->where('id','<>', $request->id)->count();
                    }else{
                        $checkExits = $checkExits->count();
                    }
                    if ($checkExits > 0) {
                        $fail(trans('validation.unique'));
                    };
                }
            ],
            'address' => [
                'required','max:255',
            ],
            'phone' => [
                'required','digits_between:9,11','numeric',
            ],
            'language' => [
                'required'
            ],
            'gender' => [
                'required'
            ]
        ]);

        return $validation;
    }

    function unlock(Request $req)
    {
        $customer = $this->fetchById($req->get('id'));
        $customer->lock_flg = Customer::UNLOCK;
        $customer->status = Customer::STATUS_ACTIVITE;
        if ($customer->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function lock(Request $req)
    {
        $customer = $this->fetchById($req->get('id'));
        $customer->lock_flg = Customer::LOCK;
        $customer->status = Customer::STATUS_LOCK;
        if ($customer->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function reset(Request $req)
    {
        $customer = $this->fetchById($req->get('id'));
        $customer->password = bcrypt($this->randomPassword(10));
        $customer->updated = time();
        $customer->password_status = 0;
        if ($customer->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function randomPassword($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[mt_rand(0, strlen($codeAlphabet) - 1)];
        }
        return $token;
    }
}