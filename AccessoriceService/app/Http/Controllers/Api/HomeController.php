<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Service\Shop\HomeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{

    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function getBanners(){

        $banners = $this->homeService->banners();

        return response()->json($banners, Response::HTTP_OK);
    }

    public function getBrands()
    {
        $brands = $this->homeService->brands();

        return \response()->json($brands, Response::HTTP_OK);
    }

    public function getCategory(Request $req){
        $id = $req->get('brandId');

        $categories = $this->homeService->category($id);

        return \response()->json($categories,Response::HTTP_OK);
    }

    public function getProducts(Request $req){
        $id = $req->get('categoryId');

        $products = $this->homeService->products($id);

        return \response()->json($products, Response::HTTP_OK);
    }

    public function getProductById(Request $req){
        $id = $req->get('productId');

        $product = $this->homeService->productById($id);

        return \response()->json($product, Response::HTTP_OK);
    }

    public function getImagesProduct(Request $req){
        $id = $req->get('productId');

        $product_img = $this->homeService->imagesProduct($id);

        return \response()->json($product_img, Response::HTTP_OK);
    }

    public function doLogin(Request $req){
        $customer = $this->homeService->login($req);

        if (!$customer){
            return \response()->json(false,Response::HTTP_OK);
        }
        return \response()->json($customer,Response::HTTP_OK);
    }

    public function doRegister(Request $req){
        $customer = $this->homeService->register($req);

        if (!$customer){
            return \response()->json(false,Response::HTTP_OK);
        }
        return \response()->json($customer,Response::HTTP_OK);
    }

    public function doCheck(Request $req){
        $check = $this->homeService->checkexist($req);
        $exist = array();
        if ($check){
            $exist['exists'] = true;
            return \response()->json($exist,Response::HTTP_OK);
        }else{
            $exist['exists'] = false;
            return \response()->json($exist,Response::HTTP_OK);
        }
    }

    public function doUploadAV(Request $request){
        $customer = $this->homeService->avatar($request);

        return \response()->json($customer, Response::HTTP_OK);
    }

    public function getProductsAll(){
        $all = $this->homeService->allProduct();

        return \response()->json($all, Response::HTTP_OK);
    }

    public function doOrder(Request $request){
        $invoice = $this->homeService->order($request);

        return \response()->json($invoice, Response::HTTP_OK);
    }

    public function allInvoice(Request $request){
        $invoice = $this->homeService->invoiceList($request);

        return \response()->json($invoice, Response::HTTP_OK);
    }

    public function allHistory(Request $request){
        $invoice = $this->homeService->history($request);

        return \response()->json($invoice, Response::HTTP_OK);
    }

    public function allInvoiceDetail(Request $request){
        $detail = $this->homeService->invoiceListDetail($request);

        return \response()->json($detail, Response::HTTP_OK);
    }

    public function doCanceled(Request $request){
        $detail = $this->homeService->cancelOrder($request);
        return \response()->json($detail, Response::HTTP_OK);
    }

    public function doChangeInfo(Request $request){
        $detail = $this->homeService->changeInfo($request);
        return \response()->json($detail, Response::HTTP_OK);
    }
}