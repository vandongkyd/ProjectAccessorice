<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\InvoiceDetailService;
use App\Service\Admin\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class InvoiceController extends Controller
{

    /**
     * @var InvoiceService
     */
    private $invoiceService;

    /**
     * @var InvoiceDetailService
     */
    private $invoiceDetailService;

    public function __construct(InvoiceService $invoiceService, InvoiceDetailService $invoiceDetailService)
    {
        $this->middleware('auth:admin');
        $this->invoiceService = $invoiceService;
        $this->invoiceDetailService = $invoiceDetailService;
    }

    /**
     * @return View: Admin.Invoice.List
     */
    public function index(){
        $invoices = $this->invoiceService->list();

        return view('admin.invoice.index',[
            'invoices' => $invoices
        ]);
    }

    /**
     * @return View: Admin.Invoice.Add
     */
    public function add(){
        return view('admin.invoice.add');
    }

    /**
     * @action Add record Invoice
     * @param Request $req
     * @return View: Admin.Invoice.List
     */
    public function doAdd(Request $req){
        try {
            $invoice = $this->invoiceService->add($req);
            if($invoice['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.invoice')]);
                return redirect()->route('invoice.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.invoice')]);
                return redirect()->route('invoice.add')->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($invoice['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @return View: Admin.Invoice.Edit
     */
    public function edit($id){
        $invoice = $this->invoiceService->detail($id);
        $shopInfo = $this->invoiceService->fetchShopById(Auth::user()->id);
        $invoiceList = $this->invoiceService->detailList($id);
        $invoicePayeasy = $this->invoiceService->getTotalAmount($id);
        return view('admin.invoice.edit',[
            'invoice' => $invoice,
            'invoiceList' => $invoiceList,
            'shopInfo' => $shopInfo,
            'subtotal' => $invoicePayeasy['subtotal'],
        ]);
    }

    /**
     * @action Update record Invoice
     * @param Request $req
     * @return View: Admin.Invoice.List
     */
    public function doEdit(Request $req){
        try {
            $invoice = $this->invoiceService->edit($req);
            if ($invoice['status']) {
                $msg = Lang::get('messages.lbl_notification.success', ['action' => Lang::get('messages.lbl_action.update'), 'name' => Lang::get('messages.lbl_screen_menu.invoice')]);
                return redirect()->route('invoice.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message' => $msg]);
            } else {
                $msg = Lang::get('messages.lbl_notification.error', ['action' => Lang::get('messages.lbl_action.update'), 'name' => Lang::get('messages.lbl_screen_menu.invoice')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message' => $msg])->withErrors($invoice['validate'])->withInput();
            }
        }catch (\Exception $ex){
            return view('admin.errors.404');
        }
    }

    /**
     * @action Delete record Invoice
     * @param Request $req
     * @return View: Admin.Invoice.List
     */
    public function doDelete(Request $req){
        try{
            $invoice = $this->invoiceService->delete($req);
            if ($invoice['status']) {
                $msg = Lang::get('messages.lbl_notification.success', ['action' => Lang::get('messages.lbl_action.delete'), 'name' => Lang::get('messages.lbl_screen_menu.invoice')]);
                return redirect()->route('invoice.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message' => $msg]);
            } else {
                $msg = Lang::get('messages.lbl_notification.error', ['action' => Lang::get('messages.lbl_action.delete'), 'name' => Lang::get('messages.lbl_screen_menu.invoice')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message' => $msg])->withErrors($invoice['validate']);
            }
        }catch (\Exception $ex){
            return view('admin.errors.404');
        }
    }

    /**
     * @return View: Admin.Invoice.Detail
     */
    public function detail($id){
        $invoice = $this->invoiceService->detail($id);
        $shopInfo = $this->invoiceService->fetchShopById(Auth::user()->id);
        $invoiceList = $this->invoiceService->detailList($id);
        $invoicePayeasy = $this->invoiceService->getTotalAmount($id);
        return view('admin.invoice.detail',[
            'invoice' => $invoice,
            'invoiceList' => $invoiceList,
            'shopInfo' => $shopInfo,
            'subtotal' => $invoicePayeasy['subtotal'],
        ]);
    }

    /**
     * @action Export Invoice
     * @param Request $req
     * @return View: Admin.Invoice.PDF
     */
    public function exportInvoice($id){
        $pdf = \App::make('dompdf.wrapper');
        $invoice = $this->invoiceService->detail($id);
        $shopInfo = $this->invoiceService->fetchShopById(Auth::user()->id);
        $invoiceList = $this->invoiceService->detailList($id);
        $invoicePayeasy = $this->invoiceService->getTotalAmount($id);
        $pdf->loadHTML(\view('admin.invoice.detailPDF', [
            'invoice' => $invoice,
            'invoiceList' => $invoiceList,
            'shopInfo' => $shopInfo,
            'subtotal' => $invoicePayeasy['subtotal'],
        ]))->setPaper('A4', 'portrait');
        return $pdf->stream('billing');
    }
}
