<?php

namespace App\Service\Shop;


use Illuminate\Http\Request;

interface HomeService
{
    function banners();

    function brands();

    function category($id);

    function products($id);

    function allProduct();

    function productById($id);

    function imagesProduct($id);

    function login(Request $request);

    function register(Request $request);

    function checkexist(Request $request);

    function avatar(Request $request);

    function order(Request $request);

    function invoiceList(Request $request);

    function history(Request $request);

    function invoiceListDetail(Request $request);

    function cancelOrder(Request $request);

    function changeInfo(Request $request);
}