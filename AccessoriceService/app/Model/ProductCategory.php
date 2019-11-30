<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string category_name
 * @property int brand_id
 * @property int discount_id
 * @property int category_status
 * @property int created
 */
class ProductCategory extends BaseModel
{
    protected $table = 't_product_category';
}
