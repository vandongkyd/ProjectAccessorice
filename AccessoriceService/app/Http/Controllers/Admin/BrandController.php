<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class BrandController extends Controller
{
    /**
     * @var BrandService
     */
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->middleware('auth:admin');
        $this->brandService = $brandService;
    }

    /**
     * @return View: Admin.Brand.List
     */
    public function index(){

        $brands = $this->brandService->list();

        return view('admin.brand.index',[
            'brands' => $brands
        ]);
    }

    /**
     * @return View: Admin.Brand.Add
     */
    public function add(){

        $discounts = $this->getDiscount();

        return view('admin.brand.add',[
            'discounts' => $discounts
        ]);
    }

    /**
     * @action Add record Brand
     * @param Request $req
     * @return View: Admin.Brand.List
     */
    public function doAdd(Request $req){

        try {
            $brand = $this->brandService->add($req);
            if($brand['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.brand')]);
                return redirect()->route('brand.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.brand')]);
                return redirect()->route('brand.add')->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($brand['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @param $id
     * @return View: Admin.Brand.Edit
     */
    public function edit($id){

        $discounts = $this->getDiscount();
        $brand = $this->brandService->fetchById($id);

        return view('admin.brand.edit',[
            'discounts' => $discounts,
            'brand' => $brand
        ]);
    }

    /**
     * @action Update record Brand
     * @param Request $req
     * @return View: Admin.Brand.List
     */
    public function doEdit(Request $req){

        try {
            $brand = $this->brandService->edit($req);
            if ($brand['status']) {
                $msg = Lang::get('messages.lbl_notification.success', ['action' => Lang::get('messages.lbl_action.update'), 'name' => Lang::get('messages.lbl_screen_menu.brand')]);
                return redirect()->route('brand.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message' => $msg]);
            } else {
                $msg = Lang::get('messages.lbl_notification.error', ['action' => Lang::get('messages.lbl_action.update'), 'name' => Lang::get('messages.lbl_screen_menu.brand')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message' => $msg])->withErrors($brand['validate'])->withInput();
            }
        }catch (\Exception $ex){
            return view('admin.errors.404');
        }
    }

    /**
     * @action Delete record Brand
     * @param Request $req
     * @return View: Admin.Brand.List
     */
    public function doDelete(Request $req){

        try{
            $brand = $this->brandService->delete($req);
            if ($brand['status']) {
                $msg = Lang::get('messages.lbl_notification.success', ['action' => Lang::get('messages.lbl_action.delete'), 'name' => Lang::get('messages.lbl_screen_menu.brand')]);
                return redirect()->route('brand.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message' => $msg]);
            } else {
                $msg = Lang::get('messages.lbl_notification.error', ['action' => Lang::get('messages.lbl_action.delete'), 'name' => Lang::get('messages.lbl_screen_menu.brand')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message' => $msg])->withErrors($brand['validate']);
            }
        }catch (\Exception $ex){
            return view('admin.errors.404');
        }
    }
}
