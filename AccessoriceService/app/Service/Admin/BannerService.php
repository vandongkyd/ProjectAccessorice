<?php

namespace App\Service\Admin;


use Illuminate\Http\Request;

interface BannerService
{
    function list();

    function add(Request $req);

    function edit(Request $req);

    function delete(Request $req);

    function fetchById($id);

    function fetchSortBanner();

    function validation(Request $req,$mod);

    function getProduct();

    function getProductCategory();
}