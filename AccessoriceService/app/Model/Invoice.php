<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string invoice_no
 * @property int purchase_date
 * @property int delivery_date
 * @property string recipient_name
 * @property string phone
 * @property string address
 * @property int payment_status
 * @property int customer_id
 * @property int ship_id
 * @property int type_delivery
 * @property string discount_code
 * @property int created
 * @property int updated
 * @property double total_amount
 * @property int id
 */
class Invoice extends BaseModel
{

    protected $table = 't_invoice';

}
