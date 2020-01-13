<?php

namespace App\ServiceImpl\Admin;


use App\Model\Customer;
use App\Model\Invoice;
use App\Model\Product;
use App\Service\Admin\DashboardService;
use Illuminate\Support\Facades\DB;

class DashboardServiceImpl implements DashboardService
{

    function getCustomer()
    {
       $customers = Customer::where('del_flg','=', Customer::DEL_FLG)->get();

       return $customers;
    }

    function getInvoice()
    {
        $invoices = Invoice::where('del_flg','=', Invoice::DEL_FLG)->get();

        return $invoices;
    }

    function getProduct()
    {
        $products = Product::where('del_flg','=', Product::DEL_FLG)->get();

        return $products;
    }

    function recentTransaction()
    {
        $timeold = strtotime('-5 day', time());
        $invoices = DB::table('t_invoice')
            ->select('t_invoice.*')
            ->where('del_flg', '=', Invoice::DEL_FLG)
            ->whereBetween('created',[$timeold, time()])->take(5)
            ->get();
        return $invoices;
    }

    function totalAmount()
    {
        $invoices = $this->getInvoice();
        $subtotal = 0;
        $new = 0;
        $inprogress = 0;
        $shipping = 0;
        $done = 0;
        if (count($invoices) > 0 ){
            foreach ($invoices as $invoice){
                $subtotal += $invoice->total_amount;
                if ($invoice->invoice_status == 0){
                    $new += $invoice->total_amount;
                }elseif ($invoice->invoice_status == 1){
                    $inprogress += $invoice->total_amount;
                }elseif ($invoice->invoice_status == 2){
                    $shipping += $invoice->total_amount;
                }elseif ($invoice->invoice_status == 3){
                    $done += $invoice->total_amount;
                }
            }
        }
        $totalReport = [
            'new' => $new,
            'inprogress' => $inprogress,
            'shipping' => $shipping,
            'done' => $done,
            'subtotal' => $subtotal,
        ];
        return $totalReport;
    }

    function getTotalRe()
    {
        $invoices = Invoice::select('total_amount')
            ->where('del_flg','=', Invoice::DEL_FLG)
            ->orderBy('total_amount','asc')
            ->get();
        return $invoices;
    }

    function getReNew()
    {
        $invoices = Invoice::select('total_amount')
            ->where('invoice_status', '=' , Invoice::NEW)
            ->where('del_flg','=', Invoice::DEL_FLG)
            ->orderBy('total_amount','asc')
            ->get();
        return $invoices;
    }

    function getReInprogress()
    {
        $invoices = Invoice::select('total_amount')
            ->where('invoice_status', '=' , Invoice::IN_PROGRESS)
            ->where('del_flg','=', Invoice::DEL_FLG)
            ->orderBy('total_amount','asc')
            ->get();
        return $invoices;
    }

    function getReShipping()
    {
        $invoices = Invoice::select('total_amount')
            ->where('invoice_status', '=' , Invoice::SHIPPING)
            ->where('del_flg','=', Invoice::DEL_FLG)
            ->orderBy('total_amount','asc')
            ->get();
        return $invoices;
    }

    function getReDone()
    {
        $invoices = Invoice::select('total_amount')
            ->where('invoice_status', '=' , Invoice::DELIVERED)
            ->where('del_flg','=', Invoice::DEL_FLG)
            ->orderBy('total_amount','asc')
            ->get();
        return $invoices;
    }
}