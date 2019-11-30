<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->invoice_no }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        h1,h2,h3,h4,h5,h6,p,span,div { font-family: DejaVu Sans; }
        .font-size18 {
            font-size: 14px;
        }

        h5{
            margin-bottom: -2px !important;
        }
        .form-with-none{
            resize: none;
            max-width: none;
        }
        span{
            color: #000;
        }

        .tr-text-total {
            background: #fff !important;
        }

        .td-borde-none {
            border: initial !important;
        }

        .col-wrap {
            display: table;
            width: 100%;
            margin-top: -15px;
        }

        .col {
            display: table-cell;
        }
        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
<div>
    <div class="col-wrap">
        <div class="col" style="width: 50%">
            <img src="./img/newlogo.png" style="width: 200px; height: 90px;">
        </div>
        <div class="col" style="width: 50%;">
            <div class="pull-right">
                <label class="font-size18">Shop :<span>{{$shopInfo->shop_name}}</span></label><br>
                <label class="font-size18">Date :<span>{{ date('Y-m-d H:i:s') }}</span></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group pull-left">
                <label class="font-size18">{{__('messages.lbl_invoice')}}: <span>{{$invoice->invoice_no}}</span></label><br>
                <label>{{__('messages.lbl_order_date')}}: <span>{{date('d/m/Y',$invoice->created)}}</span></label>
            </div>
        </div>
    </div>
    <div class="col-wrap">
        <div class="col" style="width: 50%;padding-right: 10px;">
            <label>{{__('messages.lbl_business_detail')}}</label>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5>Name: <span>{{$shopInfo->shop_name}}</span></h5>
                    <h5>Phone: <span>{{$shopInfo->shop_phone}}</span></h5>
                    <h5>Address: <span>{{$shopInfo->shop_address}}</span></h5>
                </div>
            </div>
        </div>

        <div class="col" style="width: 50%; padding-left: 10px;">
            <label>{{__('messages.lbl_customer_detail')}}</label>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h5>Name: <span>{{$invoice->recipient_name}}</span></h5>
                    <h5>Phone: <span>{{$invoice->phone}}</span></h5>
                    <h5>Address: <span>{{$invoice->addressCustomer}}</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-wrap">
        <div class="col" style="width: 30%;padding-right: 10px;">
            <label>{{__('messages.lbl_bill_address')}}</label>
            <div class="panel panel-default">
                <div class="panel-body" style="height: 45px;">
                    <h5><span>{{$invoice->address}}</span></h5>
                </div>
            </div>
        </div>

        <div class="col" style="width: 30%;padding-right: 10px;padding-left: 10px;">
            <label>{{__('messages.lbl_shipping_address')}}</label>
            <div class="panel panel-default">
                <div class="panel-body" style="height: 45px;">
                    <h5><span>{{$invoice->addressCustomer}}</span></h5>
                </div>
            </div>
        </div>

        <div class="col" style="width: 30%;padding-left: 10px;">
            <label>{{__('messages.lbl_shipping_method')}}</label>
            <div class="panel panel-default">
                <div class="panel-body" style="height: 45px;">
                    @foreach(__('messages.lbl_list_delivery') as $key => $value)
                        @if($key == $invoice->ship_id)
                            <h5><span>{{$value}}</span></h5>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <h5 style="margin-top: -8px !important; margin-bottom: 3px !important;">This is information customers order infor</h5>
    <table class="table table-bordered" id="customers">
        <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>{{ __('messages.lbl_product_name')}}</th>
            <th class="text-right">{{ __('messages.lbl_price')}}</th>
            <th>{{ __('messages.lbl_quantity')}}</th>
            <th class="text-right">{{ __('messages.lbl_total')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoiceList as $invoiceItem)
            <tr>
                <td>{{$invoiceItem->id}}</td>
                <td>{{$invoiceItem->product_code}}</td>
                <td>{{$invoiceItem->product_name}}</td>
                <td class="text-right">{{number_format($invoiceItem->product_price)}}</td>
                <td>{{$invoiceItem->quality_item}}</td>
                <td class="text-right">{{number_format($invoiceItem->amount)}}
                    <span>VND</span></td>
            </tr>
        @endforeach
        <tr class="tr-text-total" role="row">
            <td class="td-borde-none" colspan="4"></td>
            <td style="font-weight: bold">{{__('messages.lbl_subtotal')}}</td>
            <td class="text-right">{{number_format($subtotal)}} <span>VND</span></td>
        </tr>
        <tr class="tr-text-total" role="row">
            <td class="td-borde-none" colspan="4"></td>
            <td style="font-weight: bold">{{__('messages.lbl_discount')}}</td>
            <td class="text-right">{{number_format(($subtotal * $invoice->percent_reduction)/100)}}  <span>VND</span></td>
        </tr>
        <tr class="tr-text-total" role="row">
            <td class="td-borde-none" colspan="4"></td>
            <td style="font-weight: bold">{{__('messages.lbl_shipping')}}</td>
            <td class="text-right">{{number_format($invoice->ship_price)}} <span>VND</span></td>
        </tr>
        <tr class="tr-text-total" role="row">
            <td class="td-borde-none" colspan="4"></td>
            <td style="font-weight: bold">{{__('messages.lbl_total')}}</td>
            <td class="text-right">{{number_format($subtotal - (($subtotal * $invoice->percent_reduction)/100) + $invoice->ship_price)}}<span>VND</span></td>
        </tr>
        </tbody>
    </table>
    <h5 style="font-weight: bold;">Note</h5>
    <div class="col-wrap" style="margin-top: 10px">
        <div class="col" style="width: 50%">
            <label>
                <textarea class="form-control form-with-none" rows="5" style="height: 50px;">asdsad</textarea>
            </label>
        </div>
        <div class="col" style="width: 50%;">
            <h5 style="text-align: center; font-weight: bold;">Sign</h5>
        </div>
    </div>

</div>
</body>
</html>
