<?php

namespace App\Service\Admin;


use Illuminate\Http\Request;

interface ProductService
{

    function list();

    function listImages($id);

    function add(Request $req);

    function edit(Request $req);

    function delete(Request $req);

    function fetchById($id);

    function fetchImageById($id);

    function fetchDetailById($id);

    function deleteImage($file_name);

    function moveAndRemove($file_name);

    function validation(Request $req);
}