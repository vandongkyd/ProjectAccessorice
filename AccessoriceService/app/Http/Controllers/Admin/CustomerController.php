<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CustomerController extends Controller
{
    /**
     * @var CustomerService
     */
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->middleware('auth:admin');
        $this->customerService = $customerService;
    }

    /**
     * @return View: Admin.Customer.List
     */
    public function index(){
        return view('admin.customer.index');
    }

    /**
     * @return View: Admin.Customer.Add
     */
    public function add(){
        return view('admin.customer.add');
    }

    /**
     * @return View: Admin.Customer.Edit
     */
    public function edit(){
        return view('admin.customer.edit');
    }
}
