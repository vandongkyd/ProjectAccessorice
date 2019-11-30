<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int product_id
 * @property string file_name
 * @property int sort_no
 * @property int id
 */
class ProductImage extends BaseModel
{
    protected $table = 't_product_image';
}
