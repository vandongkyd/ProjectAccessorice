<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int invoice_id
 * @property int product_id
 * @property int quality_item
 * @property string amount
 * @property int created
 * @property int updated
 */
class InvoiceDetail extends BaseModel
{
    protected $table = 't_invoice_detail';
}
