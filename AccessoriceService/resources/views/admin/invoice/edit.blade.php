@extends('admin.layout.layout_manage_default')


@section('title', 'Accessories | '.__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.invoice')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.invoice')}} <span>/ {{__('messages.lbl_header_edit')}}</span></h3>
@stop


@section('content-body')
    <div class="row">
        <!--Invoice Head Start-->
        <div class="col-12 mb-30">
            <div class="box">
                <form id="f_submit" action="{{ route("invoice.submit.edit") }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input name="id" value="{{$invoice->id}}" type="hidden">
                    <div class="col-lg-12 col-12 mb-30 invoice">
                        <div class="col-12">
                            <div class="invoice-head">
                                <h2 class="fw-700 mt-5 mb-3">{{ __('messages.lbl_invoice')}}:
                                    <span>{{$invoice->invoice_no}}</span></h2>
                                <p>{{ __('messages.lbl_order_date')}}:
                                    <span>{{date('d/m/Y', $invoice->created)}}</span></p>
                                <hr>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group pull-left">
                                <h4 class="font-size18 mt-2">{{__('messages.lbl_business_detail')}}</h4>
                                <p>Name: <span>{{$shopInfo->shop_name}}</span></p>
                                <p>Phone: <span>{{$shopInfo->shop_phone}}</span></p>
                                <p>Address: <span>{{$shopInfo->shop_address}}</span></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group pull-left">
                                <h4 class="font-size18 mt-2">{{__('messages.lbl_customer_detail')}}</h4>
                                <p>Name: <span>{{$invoice->recipient_name}}</span></p>
                                <p>Phone: <span>{{$invoice->phone}}</span></p>
                                <p>Address: <span>{{$invoice->addressCustomer}}</span></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group pull-left">
                                <h4 class="font-size18 mt-2">{{__('messages.lbl_bill_address')}}</h4>
                                <p><span>{{$invoice->address}}</span></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group pull-left">
                                <h4 class="font-size18 mt-2">{{__('messages.lbl_shipping_address')}}</h4>
                                <p><span>{{$invoice->addressCustomer}}</span></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group pull-left">
                                <h4 class="font-size18 mt-2">{{__('messages.lbl_shipping_method')}}</h4>
                                @foreach(__('messages.lbl_list_delivery') as $key => $value)
                                    @if($key == $invoice->ship_id)
                                        <p><span>{{$value}}</span></p>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-12 col-12 mt-30 mb-30">
                            <div class="form-group">
                                <table class="col-md-12" id="customers">
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
                                        <td class="text-right">{{number_format($subtotal)}}
                                            <span>VND</span>
                                        </td>
                                    </tr>
                                    <tr class="tr-text-total" role="row">
                                        <td class="td-borde-none" colspan="4"></td>
                                        <td style="font-weight: bold">{{Lang::get('messages.lbl_discount')}}
                                            ({{$invoice->percent_reduction}}%)
                                        </td>
                                        <td class="text-right">{{number_format(($subtotal * $invoice->percent_reduction)/100)}}
                                            <span>VND</span></td>
                                    </tr>
                                    <tr class="tr-text-total" role="row">
                                        <td class="td-borde-none" colspan="4"></td>
                                        <td style="font-weight: bold">{{Lang::get('messages.lbl_shipping')}}</td>
                                        <td class="text-right">
                                            {{number_format($invoice->ship_price)}}
                                            <span>VND</span></td>
                                    </tr>
                                    <tr class="tr-text-total" role="row">
                                        <td class="td-borde-none" colspan="4"></td>
                                        <td style="font-weight: bold">{{Lang::get('messages.lbl_total')}}</td>
                                        <td class="text-right">{{number_format($subtotal - (($subtotal * $invoice->percent_reduction)/100) + $invoice->ship_price)}}
                                            <span>VND</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-md-12" style="margin-top: 50px;">
                                <div class="step-inner">
                                    <div class="step-line"></div>
                                    <ul>
                                        <li class="step @if(in_array($invoice->invoice_status, [0,1,2,3,4])) active-sp @endif">
                                            <img class="@if(in_array($invoice->invoice_status, [1,2,3,4])) show_img @else hide_img @endif"
                                                 src="{{asset('/img/checkmark.png')}}">
                                            <img class="mt-3"
                                                 src="@if(in_array($invoice->invoice_status, [0,1,2,3,4])) {{asset('/img/shopping.png')}} @else {{asset('/img/shoppingdf.png')}} @endif">
                                            <label class="mt-2 ml-2">New</label>
                                        </li>
                                        <li class="step @if(in_array($invoice->invoice_status, [1,2,3,4])) active-sp @endif">
                                            <img class="@if(in_array($invoice->invoice_status, [2,3,4])) show_img @else hide_img @endif"
                                                 src="{{asset('/img/checkmark.png')}}">
                                            <img class="mt-3"
                                                 src="@if(in_array($invoice->invoice_status, [1,2,3,4])) {{asset('/img/manufacture.png')}} @else {{asset('/img/manufacturedf.png')}} @endif">
                                            <label class="w-150px mt-2">In Progress</label>
                                        </li>
                                        <li class="step @if(in_array($invoice->invoice_status, [2,3,4])) active-sp @endif">
                                            <img class="@if(in_array($invoice->invoice_status, [3,4])) show_img @else hide_img @endif"
                                                 src="{{asset('/img/checkmark.png')}}">
                                            <img class="mt-3"
                                                 src="@if(in_array($invoice->invoice_status, [2,3,4])) {{asset('/img/truck.png')}} @else {{asset('/img/truckdf.png')}} @endif">
                                            <label class="w-150px mt-2">Shipping</label>
                                        </li>
                                        <li class="step @if(in_array($invoice->invoice_status, [3,4])) active-sp @endif">
                                            <img class="@if(in_array($invoice->invoice_status, [4])) show_img @else hide_img @endif"
                                                 src="{{asset('/img/checkmark.png')}}">
                                            <img class="mt-3"
                                                 src="@if(in_array($invoice->invoice_status, [3,4])) {{asset('/img/delivery-man.png')}} @else {{asset('/img/delivery-mandf.png')}} @endif">
                                            <label class="mt-2 ml-2">Done</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-20">
                            <label for="ship_status">{{__('messages.lbl_table_invoice.invoice_status')}}</label>
                            <select id="invoice_status" class="form-control" name="invoice_status">
                                @foreach(__('messages.lbl_invoice_active') as $key => $value)
                                    <option {{old("invoice_status",$invoice->invoice_status) == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-20">
                            <a href="{{route("invoice.list")}}" role="button"
                               class="button button-sm button-outline button-danger button-long text-center">
                                <span><i class="fa fa-undo"></i>{{__('messages.lbl_btn.btn_back')}}</span>
                            </a>
                            <button type="submit" class="button button-sm button-outline button-primary button-long">
                                <span><i class="fa fa-refresh"></i>{{__('messages.lbl_btn.btn_update')}}</span>
                            </button>
                        </div>
                        <!--Invoice Details Table End-->
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop