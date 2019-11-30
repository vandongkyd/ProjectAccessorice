<?php

namespace App\ServiceImpl\Admin;


use App\Model\User;
use App\Service\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserServiceImpl implements UserService
{

    function list()
    {
        $users = User::where('del_flg', '=', User::DEL_FLG)->get();

        return $users;
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
        $user = new User();
        $user->first_name = $req->get('first_name');
        $user->last_name = $req->get('last_name');
        $user->user_name = $req->get('user_name');
        $user->email = $req->get('email');
        $user->shop_id = $req->get('shop_id');
        $user->phone = $req->get('phone');
        $user->language = $req->get('language');
        $user->address = $req->get('address');
        $user->gender = $req->get('gender');
        $user->role_id = $req->get('role_id');
        $user->status = $req->get('status');
        $user->password = bcrypt($this->randomPassword(10));
        $user->created = time();
        if ($user->save()){
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

        $user = $this->fetchById($req->get('id'));
        $user->first_name = $req->get('first_name');
        $user->last_name = $req->get('last_name');
        $user->user_name = $req->get('user_name');
        $user->email = $req->get('email');
        $user->shop_id = $req->get('shop_id');
        $user->phone = $req->get('phone');
        $user->language = $req->get('language');
        $user->address = $req->get('address');
        $user->gender = $req->get('gender');
        $user->role_id = $req->get('role_id');
        $user->status = $req->get('status');
        $user->updated = time();
        if ($user->save()){
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
        $user = $this->fetchById($req->get('id'));
        $user->del_flg = User::DELETE;

        if ($user->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function unlock(Request $req)
    {
        $user = $this->fetchById($req->get('id'));
        $user->lock_flg = User::UNLOCK;
        $user->status = User::STATUS_ACTIVITE;
        if ($user->save()){
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
        $user = $this->fetchById($req->get('id'));
        $user->lock_flg = User::LOCK;
        $user->status = User::STATUS_LOCK;
        if ($user->save()){
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
        $user = $this->fetchById($req->get('id'));
        $user->password = bcrypt($this->randomPassword(10));
        $user->updated = time();
        $user->password_status = 0;
        if ($user->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function changeLanguage(Request $req)
    {
        $user = $this->fetchById($req->get('id'));
        $user->language = $req->get('language');
        $user->updated = time();

        if ($user->save()){
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
        return User::findOrFail($id);
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
                    $checkExits = DB::table('users')
                        ->where('user_name', '=', $value)
                        ->where('del_flg', '=', User::DEL_FLG);
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
                    $checkExits = DB::table('users')
                        ->where('email', '=', $value)
                        ->where('del_flg', '=', User::DEL_FLG);
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
            'role_id' => [
                'required'
            ],
            'shop_id' => [
                'required'
            ],
            'gender' => [
                'required'
            ]
        ]);

        return $validation;
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