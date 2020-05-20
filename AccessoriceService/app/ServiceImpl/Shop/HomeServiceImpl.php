<?php

namespace App\ServiceImpl\Shop;


use App\Model\Banner;
use App\Model\Brand;
use App\Model\Customer;
use App\Model\Discount;
use App\Model\Invoice;
use App\Model\InvoiceDetail;
use App\Model\Product;
use App\Model\ProductCategory;
use App\Model\ProductImage;
use App\Service\Shop\HomeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeServiceImpl implements HomeService
{

    function banners()
    {
        $date = date('Y-m-d',time());
        $banners = Banner::select('*')
            ->where('del_flg','=', Banner::DEL_FLG)
            ->where('banner_status','=', Banner::PUBLIC)
            ->where(function ($query) use ($date) {
                $query->where(DB::raw("(DATE_FORMAT(from_unixtime(banner_date_start),'%Y-%m-%d'))"), '<', $date)
                ->where(DB::raw("(DATE_FORMAT(from_unixtime(banner_date_end),'%Y-%m-%d'))"),'>', $date);
            })->orWhere(function ($query) use ($date) {
                $query->where(DB::raw("(DATE_FORMAT(from_unixtime(banner_date_start),'%Y-%m-%d'))"), '<', $date)
                    ->whereNull('banner_date_end');
            })->orWhere(function ($query) use ($date) {
                $query->where(DB::raw("(DATE_FORMAT(from_unixtime(banner_date_end),'%Y-%m-%d'))"),'>', $date)
                    ->whereNull('banner_date_start');
            })
            ->orderBy('id','DESC')
            ->get();
        return $banners;
    }

    function brands()
    {
        $brand = Brand::select('*')
            ->where('del_flg','=', Brand::DEL_FLG)
            ->where('brand_status','=', Brand::PUBLIC)
            ->get();
        return $brand;
    }

    function category($id)
    {
        $categories = ProductCategory::select('*')
            ->where('brand_id','=', $id)
            ->get();
        return $categories;
    }

    function products($id)
    {
        $products = Product::join('t_product_image', 't_product_image.product_id', '=', 't_product.id')
            ->join('t_product_category', 't_product_category.id', '=', 't_product.category_id')
            ->join('t_discount', 't_discount.id', '=', 't_product.discount_id')
            ->select('t_product.*', 't_product_image.file_name', 't_product_category.category_name', 't_discount.discount_name','t_discount.percent_reduction')
            ->where('t_product.del_flg', '=', Product::DEL_FLG)
            ->where('t_product_category.del_flg', '=', ProductCategory::DEL_FLG)
            ->where('t_discount.del_flg', '=', Discount::DEL_FLG)
            ->where('t_product.category_id', '=', $id)
            ->groupBy('t_product_image.product_id')
            ->get();
        return $products;
    }

    function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $customer = Customer::where([
            'user_name' => $username,
        ])->first();


        if (!Hash::check($password, $customer->password)) {
            return false;
        }
        return $customer;
    }

    function register(Request $request)
    {
        $email = $request->get('email');
        $phone = $request->get('phone');
        $username = $request->get('username');
        $password = $request->get('password');

        $customer = new Customer();
        $customer->email = $email;
        $customer->phone = $phone;
        $customer->user_name = $username;
        $customer->password = bcrypt($password);
        $customer->created = time();
        if ($customer->save()){
            return $customer;
        }
    }

    function checkexist(Request $request)
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $check = Customer::where('user_name','=', $username)
            ->orWhere('email', '=', $email)
            ->first();

        return $check;
    }

    function productById($id)
    {
        $products = Product::join('t_product_category', 't_product_category.id', '=', 't_product.category_id')
            ->join('t_discount', 't_discount.id', '=', 't_product.discount_id')
            ->select('t_product.*', 't_product_category.category_name', 't_discount.discount_name','t_discount.percent_reduction')
            ->where('t_product.del_flg', '=', Product::DEL_FLG)
            ->where('t_product_category.del_flg', '=', ProductCategory::DEL_FLG)
            ->where('t_discount.del_flg', '=', Discount::DEL_FLG)
            ->where('t_product.id', '=', $id)
            ->first();
        return $products;
    }

    function imagesProduct($id)
    {
        return ProductImage::where('product_id', '=', $id)->get();
    }

    function avatar(Request $request)
    {
        $file_upload = $request->file('avatar');
        $new_name = uniqid() . '_' . time() . '.' . $file_upload->getClientOriginalExtension();
        $file_upload->move(public_path('upload'), $new_name);

        $id = $request->get('customerId');
        $customer = DB::table('t_customer')->where('id','=', $id)
            ->first();
        $customer->avatar = $new_name;
        if ($customer->save()) {
            return $customer;
        }
    }

    function allProduct()
    {
        $products = Product::join('t_product_image', 't_product_image.product_id', '=', 't_product.id')
            ->join('t_product_category', 't_product_category.id', '=', 't_product.category_id')
            ->join('t_discount', 't_discount.id', '=', 't_product.discount_id')
            ->select('t_product.*', 't_product_image.file_name', 't_product_category.category_name', 't_discount.discount_name')
            ->where('t_product.del_flg', '=', Product::DEL_FLG)
            ->where('t_product_category.del_flg', '=', ProductCategory::DEL_FLG)
            ->where('t_discount.del_flg', '=', Discount::DEL_FLG)
            ->groupBy('t_product_image.product_id')
            ->get();
        return $products;
    }

    function order(Request $request)
    {
        $total_amount = $request->get('total_amount');
        $recipient_name = $request->get('recipient_name');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $payment_status = $request->get('payment_status');
        $customer_id = $request->get('customer_id');
        $ship_id = $request->get('ship_id');
        $type_delivery = $request->get('type_delivery');
        $discount_code = $request->get('discount_code');
        $invoiceDetail = $request->get('invoiceDetail');
        $detailArray = json_decode($invoiceDetail, true);

        $invoice = new Invoice();
        $invoice->invoice_no = "INV".time();
        $invoice->purchase_date = time();
        $invoice->delivery_date = strtotime("+5 day");
        $invoice->recipient_name = $recipient_name;
        $invoice->phone = $phone;
        $invoice->address = $address;
        $invoice->payment_status = $payment_status;
        $invoice->customer_id = $customer_id;
        $invoice->ship_id = $ship_id;
        $invoice->type_delivery = $type_delivery;
        $invoice->discount_code = $discount_code;
        $invoice->total_amount = $total_amount;
        $invoice->created = time();
        $invoice->updated = time();

        if($invoice->save()){
            for ($i = 0 ; $i < count($detailArray); $i++) {
                $detail = new InvoiceDetail();
                $detail->invoice_id = $invoice->id;
                $detail->product_id = $detailArray[$i]["product_id"];
                $detail->quality_item = $detailArray[$i]["quality_item"];
                $detail->amount = $detailArray[$i]["amount"];
                $detail->created = time();
                $detail->updated = time();
                $detail->save();
            }
        };
        return $invoice;

    }

    function invoiceList(Request $request)
    {
        $customer_id = $request->get('customer_id');
        $status = $request->get("status");
        $invoice = Invoice::where('del_flg', '=', 0)
            ->where('customer_id', '=' , $customer_id)
            ->where('invoice_status','=', $status)
            ->get();

        return $invoice;
    }

    function invoiceListDetail(Request $request)
    {
        $invoice_id = $request->get('invoice_id');
        $detail = InvoiceDetail::join('t_product', 't_product.id', '=', 't_invoice_detail.product_id')
            ->join('t_product_image', 't_product_image.product_id', '=', 't_product.id')
            ->select('t_invoice_detail.*', 't_product.product_name','t_product_image.file_name')
            ->where('invoice_id','=',$invoice_id)
            ->groupBy('t_product_image.product_id')
            ->get();
        return $detail;
    }

    function history(Request $request)
    {
        $customer_id = $request->get('customer_id');
        $status = $request->get("status");
        $invoice = Invoice::where('del_flg', '=', 0)
            ->where('customer_id', '=' , $customer_id)
            ->where('invoice_status','=', $status)
            ->get();

        return $invoice;
    }

    function cancelOrder(Request $request)
    {
        $id = $request->get('invoice_id');

        $invoice = DB::table('t_invoice')
            ->where('del_flg', '=', 0)
            ->where('id', '=' , $id)->first();
        $invoice->invoice_status = '4';

        if ($invoice->save()) {
            return $invoice;
        }
    }

    function changeInfo(Request $request)
    {
        $customer = Customer::findOrFail($request->get('id'));
        if ($customer instanceof Customer) {
            $customer->first_name = $request->get('first_name');
            $customer->last_name = $request->get('last_name');
            $customer->address = $request->get('address');
            $customer->gender = $request->get('gender');
            $customer->updated = time();
            if ($customer->save()) {
                return $customer;
            }
        }
        return $customer;
    }
}
