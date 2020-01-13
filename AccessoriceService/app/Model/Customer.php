<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string email
 * @property string phone
 * @property string user_name
 * @property string password
 * @property int created
 * @property string first_name
 * @property string last_name
 * @property string language
 * @property string address
 * @property int gender
 * @property int status
 */
class Customer extends Authenticatable
{
    use Notifiable;
    const DEL_FLG = 0;
    const DELETE = 1;
    const RESET = 0;
    const UNLOCK = 0;
    const LOCK = 1;
    const STATUS_LOCK = 2;
    const STATUS_ACTIVITE = 1;
    protected $table = 't_customer';
    public $timestamps = false;
}
