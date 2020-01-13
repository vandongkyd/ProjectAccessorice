<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

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
        $customers = $this->customerService->list();
        return view('admin.customer.index',[
            'customers' => $customers
        ]);
    }

    /**
     * @return View: Admin.Customer.Add
     */
    public function add(){
        return view('admin.customer.add');
    }

    /**
     * @action Add record Customer
     * @param Request $request
     * @return View: Admin.Customer.List
     */
    public function doAdd(Request $request){
        try {
            $customer = $this->customerService->add($request);
            if($customer['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->route('customer.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->route('customer.add')->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($customer['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @return View: Admin.Customer.Edit
     */
    public function edit($id){
        $customer = $this->customerService->fetchById($id);
        return view('admin.customer.edit',[
            'customer' => $customer
        ]);
    }

    /**
     * @action Edit record Customer
     * @param Request $request
     * @return View: Admin.Customer.List
     */
    public function doEdit(Request $request){
        try {
            $customer = $this->customerService->edit($request);
            if($customer['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->route('customer.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($customer['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Delete record Customer
     * @param Request $request
     * @return View: Admin.Customer.List
     */
    public function doDelete(Request $request){
        try {
            $customer = $this->customerService->delete($request);
            if($customer['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->route('customer.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($customer['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Unlock record Customer
     * @param Request $req
     * @return View: Admin.Customer.List
     */
    public function doUnlock(Request $req){

        try {
            $customer = $this->customerService->unlock($req);
            if($customer['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.unlock'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->route('customer.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.unlock'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg]);
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Lock record Customer
     * @param Request $req
     * @return View: Admin.Customer.List
     */
    public function doLock(Request $req){

        try {
            $customer = $this->customerService->lock($req);
            if($customer['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.lock'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->route('customer.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.lock'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg]);
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Reset record Customer
     * @param Request $req
     * @return View: Admin.Customer.List
     */
    public function doReset(Request $req){

        try {
            $customer = $this->customerService->reset($req);
            if($customer['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.reset'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->route('customer.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.reset'),'name' => Lang::get('messages.lbl_screen_menu.customers')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg]);
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }
}
