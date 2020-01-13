<?php

namespace App\Service\Admin;


interface DashboardService
{
    function getCustomer();

    function getInvoice();

    function getProduct();

    function recentTransaction();

    function totalAmount();

    function getTotalRe();
    function getReNew();
    function getReInprogress();
    function getReShipping();
    function getReDone();
}