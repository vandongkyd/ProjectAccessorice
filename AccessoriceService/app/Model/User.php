<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string first_name
 * @property string last_name
 * @property string user_name
 * @property string email
 * @property int shop_id
 * @property string phone
 * @property string language
 * @property string address
 * @property int role_id
 * @property int status
 * @property int created
 * @property string password
 * @property int gender
 */
class User extends Authenticatable
{
    use Notifiable;

    const DEL_FLG = 0;
    const DELETE = 1;
    const RESET = 0;
    const UNLOCK = 0;
    const LOCK = 1;
    const STATUS_LOCK = 2;
    const STATUS_ACTIVITE = 1;

    protected $table = 'users';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
