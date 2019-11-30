<?php

namespace App\Service\Admin;


use Illuminate\Http\Request;

interface InvoiceService
{
    function list();

    function add(Request $req);

    function edit(Request $req);

    function delete(Request $req);

    function fetchById($id);

    function validation(Request $req);

    function detail($id);

    function fetchShopById($id);

    function detailList($id);

    function getTotalAmount($id);
}