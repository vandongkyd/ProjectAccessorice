<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Service\Admin\DashboardService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


class DashboardController extends Controller
{
    /**
     * @var DashboardService
     */
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->middleware('auth:admin');
        $this->dashboardService = $dashboardService;
    }

    /**
     * @return View: Admin.Dashboard
     */
    public function index(){
        $invoices = $this->dashboardService->getInvoice();
        $customers = $this->dashboardService->getCustomer();
        $products = $this->dashboardService->getProduct();
        return view('admin.dashboard.dashboard',[
            'invoices' => $invoices,
            'customers' => $customers,
            'products' => $products
        ]);
    }
}