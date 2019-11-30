<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string ship_name
 * @property int ship_status
 * @property double ship_price
 * @property int created
 */
class ShipType extends BaseModel
{
    protected $table = 't_ship_type';
}
