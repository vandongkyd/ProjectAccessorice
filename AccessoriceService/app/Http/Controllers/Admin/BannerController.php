<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\BannerService;
use App\Service\Admin\InvoiceService;
use Mockery\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;

class BannerController extends Controller
{
    /**
     * @var BannerService
     */
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->middleware('auth:admin');
        $this->bannerService = $bannerService;
    }

    /**
     * @return View: Admin.Banner.List
     */
    public function index(){
        $banners = $this->bannerService->list();

        return view('admin.banner.index',[
            'banners' => $banners,
        ]);
    }

    /**
     * @return View: Admin.Banner.Add
     */
    public function add(){
        $products = $this->bannerService->getProduct();
        $categories = $this->bannerService->getProductCategory();
        return view('admin.banner.add',[
            'products' => $products,
            'categories' => $categories,
        ]);
    }


    /**
     * @action Add record Banner
     * @param Request $req
     * @return View: Admin.Banner.List
     */
    public function doAdd(Request $req){
        try {
            $banner = $this->bannerService->add($req);
            if($banner['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.banner')]);
                return redirect()->route('banner.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.banner')]);
                return redirect()->route('banner.add')->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($banner['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @param $id
     * @return View: Admin.Banner.Edit
     */
    public function edit($id){
        $banner = $this->bannerService->fetchById($id);
        $products = $this->bannerService->getProduct();
        $categories = $this->bannerService->getProductCategory();
        return view('admin.banner.edit',[
            'products' => $products,
            'categories' => $categories,
            'banner' => $banner
        ]);
    }

    /**
     * @action Update record Banner
     * @param Request $req
     * @return View: Admin.Banner.List
     */
    public function doEdit(Request $req){
        try {
            $banner = $this->bannerService->edit($req);
            if ($banner['status']) {
                $msg = Lang::get('messages.lbl_notification.success', ['action' => Lang::get('messages.lbl_action.update'), 'name' => Lang::get('messages.lbl_screen_menu.banner')]);
                return redirect()->route('banner.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message' => $msg]);
            } else {
                $msg = Lang::get('messages.lbl_notification.error', ['action' => Lang::get('messages.lbl_action.update'), 'name' => Lang::get('messages.lbl_screen_menu.banner')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message' => $msg])->withErrors($banner['validate'])->withInput();
            }
        }catch (\Exception $ex){
            return view('admin.errors.404');
        }
    }

    /**
     * @action Delete record Banner
     * @param Request $req
     * @return View: Admin.Banner.List
     */
    public function doDelete(Request $req){
        try{
            $banner = $this->bannerService->delete($req);
            if ($banner['status']) {
                $msg = Lang::get('messages.lbl_notification.success', ['action' => Lang::get('messages.lbl_action.delete'), 'name' => Lang::get('messages.lbl_screen_menu.banner')]);
                return redirect()->route('banner.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message' => $msg]);
            } else {
                $msg = Lang::get('messages.lbl_notification.error', ['action' => Lang::get('messages.lbl_action.delete'), 'name' => Lang::get('messages.lbl_screen_menu.banner')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message' => $msg])->withErrors($banner['validate']);
            }
        }catch (\Exception $ex){
            return view('admin.errors.404');
        }
    }
}
