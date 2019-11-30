<?php

namespace App\Service\Admin;


use Illuminate\Http\Request;

interface ProductCategoryService
{
    function list();

    function add(Request $req);

    function edit(Request $req);

    function delete(Request $req);

    function fetchById($id);

    function validation(Request $req);
}