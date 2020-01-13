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
        $recentTran = $this->dashboardService->recentTransaction();
        $invoices = $this->dashboardService->getInvoice();
        $customers = $this->dashboardService->getCustomer();
        $products = $this->dashboardService->getProduct();
        $totalReport = $this->dashboardService->totalAmount();
        $totalRe = $this->dashboardService->getTotalRe();
        $totalReNew = $this->dashboardService->getReNew();
        $totalReIn = $this->dashboardService->getReInprogress();
        $totalReShip = $this->dashboardService->getReShipping();
        $totalReDone = $this->dashboardService->getReDone();
        return view('admin.dashboard.dashboard',[
            'invoices' => $invoices,
            'customers' => $customers,
            'products' => $products,
            'recentTran' => $recentTran,
            'totalReport' => $totalReport,
            'totalRe' => $totalRe,
            'totalReNew' => $totalReNew,
            'totalReIn' => $totalReIn,
            'totalReShip' => $totalReShip,
            'totalReDone' => $totalReDone,
        ]);
    }
}