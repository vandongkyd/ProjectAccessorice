<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string banner_name
 * @property string banner_img
 * @property int banner_status
 * @property int product_id
 * @property int created
 * @property int sort_no
 * @property int id
 * @property string banner_description
 * @property int category_id
 * @property int banner_date_start
 * @property int banner_date_end
 */
class Banner extends BaseModel
{
    protected $table = 't_banner';

}
