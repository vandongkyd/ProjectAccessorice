<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string shop_name
 * @property string shop_address
 * @property string shop_phone
 * @property int shop_status
 * @property int created
 */
class ShopInfo extends BaseModel
{
    protected $table = 't_shop_info';

}
