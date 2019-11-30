<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string product_code
 * @property string product_name
 * @property int category_id
 * @property double product_price
 * @property int product_quality
 * @property string product_description
 * @property string product_detail
 * @property int product_status
 * @property int discount_id
 * @property int created
 * @property int product_date_start
 * @property int product_date_end
 */
class Product extends BaseModel
{
    protected $table = 't_product';

}
