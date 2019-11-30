<?php

namespace App\Service\Admin;


interface DashboardService
{
    function getCustomer();

    function getInvoice();

    function getProduct();
}