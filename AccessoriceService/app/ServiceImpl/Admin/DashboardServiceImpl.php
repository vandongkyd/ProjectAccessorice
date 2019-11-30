<?php

namespace App\ServiceImpl\Admin;


use App\Model\Customer;
use App\Model\Invoice;
use App\Model\Product;
use App\Service\Admin\DashboardService;

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
}