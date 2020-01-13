<?php

namespace App\Service\Admin;


use Illuminate\Http\Request;

interface CustomerService
{
    function list();

    function add(Request $request);

    function edit(Request $request);

    function delete(Request $request);

    function fetchById($id);

    function validation(Request $req);

    function unlock(Request $req);

    function lock(Request $req);

    function reset(Request $req);

    function randomPassword($length);
}