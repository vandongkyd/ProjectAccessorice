<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware('auth:admin');
        $this->productService = $productService;
    }

    /**
     * @return View: Admin.Product.List
     */
    public function index(){

        $products = $this->productService->list();

        return view('admin.product.index',[
            'products' => $products
        ]);
    }

    /**
     * @return View: Admin.Product.Add
     */
    public function add(){

        $categories = $this->getProductCategory();
        $discounts = $this->getDiscount();

        return view('admin.product.add',[
            'categories' => $categories,
            'discounts' => $discounts
        ]);
    }

    /**
     * @param $id
     * @return View: Admin.Product.Edit
     */
    public function edit($id){

        $product = $this->productService->fetchById($id);
        $product_images = $this->productService->listImages($id);
        $categories = $this->getProductCategory();
        $discounts = $this->getDiscount();

        return view('admin.product.edit',[
            'categories' => $categories,
            'discounts' => $discounts,
            'product' => $product,
            'product_images' => $product_images
        ]);
    }

    /**
     * @param $id
     * @return View: Admin.Product.Detail
     */
    public function detail($id){

        $product = $this->productService->fetchDetailById($id);
        $product_images = $this->productService->listImages($id);

        return view('admin.product.detail',[
            'product' => $product,
            'product_images' => $product_images
        ]);
    }

    /**
     * @action Add record Product
     * @param Request $req
     * @return View: Admin.Product.List
     */
    public function doAdd(Request $req){
        try {
            $banner = $this->productService->add($req);
            if($banner['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.product')]);
                return redirect()->route('product.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.add'),'name' => Lang::get('messages.lbl_screen_menu.product')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($banner['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Update record Product
     * @param Request $req
     * @return View: Admin.Product.List
     */
    public function doEdit(Request $req){
        try {
            $banner = $this->productService->edit($req);
            if($banner['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.product')]);
                return redirect()->route('product.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.update'),'name' => Lang::get('messages.lbl_screen_menu.product')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($banner['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }

    /**
     * @action Delete record Product
     * @param Request $req
     * @return View: Admin.Product.List
     */
    public function doDelete(Request $req){
        try {
            $category = $this->productService->delete($req);
            if($category['status']){
                $msg = Lang::get('messages.lbl_notification.success',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.product')]);
                return redirect()->route('product.list')->with(['status' => Lang::get('messages.lbl_alert.success'), 'message'=> $msg]);
            }else{
                $msg = Lang::get('messages.lbl_notification.error',['action' => Lang::get('messages.lbl_action.delete'),'name' => Lang::get('messages.lbl_screen_menu.product')]);
                return redirect()->back()->with(['status' => Lang::get('messages.lbl_alert.error'), 'message'=> $msg])->withErrors($category['validate'])->withInput();
            }
        } catch (Exception $ex) {
            return view('admin.errors.404');
        }
    }


    /**
     * @param Request $req
     * @return string file_name
     */
    public function doAddImage(Request $req){

        $extension = $req->file('file')->getClientOriginalExtension();
        $dir = public_path('upload_temp');
        $file_name = uniqid() . '_' . time() . '.' . $extension;
        $req->file('file')->move($dir, $file_name);
        return $file_name;

    }

    /**
     * @param Request $req
     * @return string file_name
     */
    public function doDeleteImage(Request $req){

        $file_name = $req->get('file_name');
        $folder_upload = public_path('upload');
        $folder_upload_temp = public_path('upload_temp');
        $upload_path = $folder_upload . '/' . $file_name;
        $upload_temp_path = $folder_upload_temp . '/' . $file_name;

        if(file_exists($upload_temp_path)){
            unlink($upload_temp_path);
        }elseif(file_exists($upload_path)){
            unlink($upload_path);
            $this->productService->deleteImage($file_name);
        }
        return $file_name;
    }
}
