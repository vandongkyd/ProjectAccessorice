<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string brand_name
 * @property int created
 * @property int brand_status
 * @property int discount_id
 * @property string brand_img
 */
class Brand extends BaseModel
{
    protected $table = 't_brand';

}
