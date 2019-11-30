<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\ShipTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class ShipTypeController extends Controller
{
    /**
     * @var ShipTypeService
     */
    private $shipTypeService;

    public function __construct(ShipTypeService $shipTypeService)
    {
        $this->middleware('auth:admin');
        $this->shipTypeService = $shipTypeService;
    }

    /**
     * @return View: Admin.ShipType.List
     */
    public function index(){

        $ships = $this->shipTypeService->list();

        return view('admin.ship_type.index',[
            'ships' => $ships
        ]);
    }

    /**
     * @return View: Admin.ShipType.Add
     */
    public function add(){
        return view('admin.ship_type.add');
    }

    /**
     * @action Add record Ship-Type
     * @param Request $req
     * @return View: Admin.ShipType.List
     */
    public function doAdd(Request $req){

        try {
            $ship = $this->shipTypeService->add($req);
            if($ship['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.ship')]);
                return redirect()->route('ship.type.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.ship')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($ship['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @param $id
     * @return View: Admin.ShipType.Edit
     */
    public function edit($id){

        $ship = $this->shipTypeService->fetchById($id);
        return view('admin.ship_type.edit',[
            'ship' => $ship
        ]);
    }

    /**
     * @action Update record Ship-Type
     * @param Request $req
     * @return View: Admin.ShipType.List
     */
    public function doEdit(Request $req){

        try {
            $ship = $this->shipTypeService->edit($req);
            if($ship['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.ship')]);
                return redirect()->route('ship.type.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.ship')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($ship['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Delete record Ship-Type
     * @param Request $req
     * @return View: Admin.ShipType.List
     */
    public function doDelete(Request $req){

        try {
            $ship = $this->shipTypeService->delete($req);
            if($ship['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.ship')]);
                return redirect()->route('ship.type.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.ship')]);
                return redirect()->route('ship.type.list')->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($ship['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }
}
