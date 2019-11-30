<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string discount_name
 * @property string percent_reduction
 * @property string gift_code
 * @property int discount_status
 * @property int created
 */
class Discount extends BaseModel
{
    protected $table = 't_discount';
}
