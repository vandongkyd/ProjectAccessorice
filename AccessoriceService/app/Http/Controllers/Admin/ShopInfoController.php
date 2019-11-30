<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\ShipTypeService;
use App\Service\Admin\ShopInfoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class ShopInfoController extends Controller
{
    /**
     * @var ShopInfoService
     */
    private $shopInfoService;

    public function __construct(ShopInfoService $shopInfoService)
    {
        $this->middleware('auth:admin');
        $this->shopInfoService = $shopInfoService;
    }

    /**
     * @return View: Admin.ShipInfo.List
     */
    public function index(){

        $shops = $this->shopInfoService->list();

        return view('admin.shop_info.index',[
            'shops' => $shops
        ]);
    }

    /**
     * @return View: Admin.ShipInfo.Add
     */
    public function add(){
        return view('admin.shop_info.add');
    }

    /**
     * @action Add record Shop-Info
     * @param Request $req
     * @return View: Admin.ShopInfo.List
     */
    public function doAdd(Request $req){

        try {
            $shop = $this->shopInfoService->add($req);
            if($shop['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.shopinfo')]);
                return redirect()->route('ship.type.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.shopinfo')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($shop['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @param $id
     * @return View: Admin.ShipInfo.Edit
     */
    public function edit($id){

        $shop = $this->shopInfoService->fetchById($id);
        return view('admin.shop_info.edit',[
            'shop' => $shop
        ]);
    }

    /**
     * @action Edit record Shop-Info
     * @param Request $req
     * @return View: Admin.ShopInfo.List
     */
    public function doEdit(Request $req){

        try {
            $shop = $this->shopInfoService->edit($req);
            if($shop['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.shopinfo')]);
                return redirect()->route('ship.type.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.shopinfo')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($shop['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Delete record Shop-Info
     * @param Request $req
     * @return View: Admin.ShopInfo.List
     */
    public function doDelete(Request $req){

        try {
            $shop = $this->shopInfoService->delete($req);
            if($shop['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.shopinfo')]);
                return redirect()->route('ship.type.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.shopinfo')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($shop['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }
}
