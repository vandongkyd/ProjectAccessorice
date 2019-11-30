<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const ADD = 'add';
    const EDIT = 'edit';
    const DEL_FLG = 0;
    const DELETE = 1;
    const PUBLIC = 1;
    const ACTIVE = 1;


    const NEW = 0;
    const IN_PROGRESS = 1;
    const SHIPPING = 2;
    const DELIVERED = 3;
    const CANCEL = 4;


    const PAID = 6;
    const PENDING = 7;
    const PROCESSING = 8;
    const RETURNED = 9;

    public $timestamps = false;
}