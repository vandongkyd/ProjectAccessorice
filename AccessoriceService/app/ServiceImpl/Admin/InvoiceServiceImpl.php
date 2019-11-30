<?php

namespace App\ServiceImpl\Admin;


use App\Model\Invoice;
use App\Model\InvoiceDetail;
use App\Model\ShopInfo;
use App\Service\Admin\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceServiceImpl implements InvoiceService
{

    function list()
    {
        $invoices = DB::table('t_invoice')
            ->select('t_invoice.*')
            ->where('del_flg', '=', Invoice::DEL_FLG)
            ->get();
        return $invoices;
    }

    function add(Request $req)
    {
        // TODO: Implement add() method.
    }

    function edit(Request $req)
    {
        $invoice = $this->fetchById($req->get('id'));
        $invoice->invoice_status = $req->get('invoice_status');
        $invoice->updated = time();

        if ($invoice->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function delete(Request $req)
    {
        $invoice = $this->fetchById($req->get('id'));
        $invoice->del_flg = "1";
        $invoice->updated = time();

        if ($invoice->save()){
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    function fetchById($id)
    {
        return Invoice::findOrFail($id);
    }

    function validation(Request $req)
    {
        // TODO: Implement validation() method.
    }

    function detail($id)
    {
        $invoice = DB::table('t_invoice')
            ->join('t_customer', 't_customer.id', '=', 't_invoice.customer_id')
            ->join('t_ship_type','t_ship_type.id', '=', 't_invoice.ship_id')
            ->join('t_discount','t_discount.id', '=', 't_invoice.discount_code')
            ->select('t_invoice.*',
                't_customer.last_name',
                't_customer.first_name',
                't_customer.email',
                't_customer.address as addressCustomer',
                't_customer.phone as phoneCustomer',
                't_ship_type.id as idShip',
                't_ship_type.ship_price',
                't_discount.percent_reduction'
            )
            ->where([
                't_invoice.id' => $id
            ])->first();

        return $invoice;
    }

    function fetchShopById($id)
    {
        $shopInfo = ShopInfo::findOrFail($id);

        return $shopInfo;
    }

    function detailList($id)
    {
        $invoiceLists = InvoiceDetail::join('t_product', 't_product.id', '=', 't_invoice_detail.product_id')
            ->where([
                'invoice_id' => $id
            ])->get();
        return $invoiceLists;
    }

    function getTotalAmount($id)
    {
        $invoices = $this->detailList($id);
        $subtotal = 0;
        if (count($invoices) > 0 ){
            foreach ($invoices as $invoice){
                $subtotal += $invoice->product_price * $invoice->quality_item;
            }
        }
        $invoicePayeasy = [
            'invoice_detail' => $invoices,
            'subtotal'    => $subtotal
        ];
        return $invoicePayeasy;
    }
}