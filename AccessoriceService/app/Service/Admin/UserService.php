<?php

namespace App\Service\Admin;


use Illuminate\Http\Request;

interface UserService
{
    function list();

    function add(Request $req);

    function edit(Request $req);

    function delete(Request $req);

    function unlock(Request $req);

    function lock(Request $req);

    function reset(Request $req);

    function changeLanguage(Request $req);

    function fetchById($id);

    function validation(Request $req);

    function randomPassword($length);
}