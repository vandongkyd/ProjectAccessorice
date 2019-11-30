<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\DiscountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class DiscountController extends Controller
{
    /**
     * @var DiscountService
     */
    private $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->middleware('auth:admin');
        $this->discountService = $discountService;
    }

    /**
     * @return View: Admin.Discount.List
     */
    public function index(){

        $discounts = $this->discountService->list();

        return view('admin.discount.index',[
            'discounts' => $discounts
        ]);
    }

    /**
     * @return View: Admin.Discount.Add
     */
    public function add(){
        return view('admin.discount.add');
    }

    /**
     * @action Add record Discount
     * @param Request $req
     * @return View: Admin.Discount.List
     */
    public function doAdd(Request $req){

        try {
            $discount = $this->discountService->add($req);
            if($discount['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.discount')]);
                return redirect()->route('discount.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.discount')]);
                return redirect()->route('discount.add')->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($discount['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @param $id
     * @return View: Admin.Discount.Edit
     */
    public function edit($id){
        $discount = $this->discountService->fetchById($id);
        return view('admin.discount.edit',[
            'discount' => $discount
        ]);
    }

    /**
     * @action Update record Discount
     * @param Request $req
     * @return View: Admin.Discount.List
     */
    public function doEdit(Request $req){

        try {
            $discount = $this->discountService->edit($req);
            if($discount['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.discount')]);
                return redirect()->route('discount.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.discount')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($discount['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Delete record Discount
     * @param Request $req
     * @return View: Admin.Discount.List
     */
    public function doDelete(Request $req){

        try {
            $discount = $this->discountService->delete($req);
            if($discount['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.discount')]);
                return redirect()->route('discount.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.discount')]);
                return redirect()->route('discount.list')->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($discount['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }
}
