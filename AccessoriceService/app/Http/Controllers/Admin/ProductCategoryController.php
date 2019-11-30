<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\ProductCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class ProductCategoryController extends Controller
{
    /**
     * @var ProductCategoryService
     */
    private $productTypeService;

    public function __construct(ProductCategoryService $productTypeService)
    {
        $this->middleware('auth:admin');
        $this->productTypeService = $productTypeService;
    }

    /**
     * @return View: Admin.ProductCategory.List
     */
    public function index(){

        $categories = $this->productTypeService->list();

        return view('admin.product_category.index',[
            'categories' => $categories
        ]);
    }

    /**
     * @return View: Admin.ProductCategory.Add
     */
    public function add(){
        $discounts = $this->getDiscount();
        $brands = $this->getBrand();
        return view('admin.product_category.add',[
            'discounts' => $discounts,
            'brands' => $brands
        ]);
    }

    /**
     * @param $id
     * @return View: Admin.ProductCategory.Edit
     */
    public function edit($id){
        $discounts = $this->getDiscount();
        $brands = $this->getBrand();
        $category = $this->productTypeService->fetchById($id);
        return view('admin.product_category.edit',[
            'discounts' => $discounts,
            'brands' => $brands,
            'category' => $category
        ]);
    }


    /**
     * @action Add record ProductCategory
     * @param Request $req
     * @return View: Admin.ProductCategory.List
     */
    public function doAdd(Request $req){
        try {
            $category = $this->productTypeService->add($req);
            if($category['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.product_category')]);
                return redirect()->route('product.category.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.product_category')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($category['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Update record ProductCategory
     * @param Request $req
     * @return View: Admin.ProductCategory.List
     */
    public function doEdit(Request $req){
        try {
            $category = $this->productTypeService->edit($req);
            if($category['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.product_category')]);
                return redirect()->route('product.category.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.product_category')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg]);
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Delete record ProductCategory
     * @param Request $req
     * @return View: Admin.ProductCategory.List
     */
    public function doDelete(Request $req){
        try {
            $category = $this->productTypeService->delete($req);
            if($category['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.product_category')]);
                return redirect()->route('product.category.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.product_category')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($category['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }
}
