@extends('admin.layout.layout_manage_default')


@section('title', 'Accessories | '.__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.shopinfo')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.shopinfo')}} <span>/ {{__('messages.lbl_header_add')}}</span></h3>
@stop


@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.shopinfo')])}}</h3>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-30">
                    <div class="box-body">
                        <form id="f_submit" action="{{ route("shop.info.submit.add") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mbn-20">
                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="shop_name">{{__('messages.lbl_table_shop.shop_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="shop_name" class="form-control"
                                                   name="shop_name" value="{{old('shop_name')}}"
                                                   placeholder="{{__('messages.lbl_table_shop.shop_name')}}">

                                            @error('shop_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="shop_phone">{{__('messages.lbl_table_shop.shop_phone')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="shop_phone" class="form-control"
                                                   name="shop_phone" value="{{old('shop_phone')}}"
                                                   placeholder="{{__('messages.lbl_table_shop.shop_phone')}}">

                                            @error('shop_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="shop_address">{{__('messages.lbl_table_shop.shop_address')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <textarea class="form-control" id="shop_address" name="shop_address" placeholder="{{__('messages.lbl_table_shop.shop_address')}}">{{old('shop_address')}}</textarea>

                                            @error('shop_address')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="shop_status">{{__('messages.lbl_table_shop.shop_status')}}</label>
                                            <select id="shop_status" class="form-control" name="shop_status">
                                                @foreach(__('messages.lbl_status_list') as $key => $value)
                                                    <option {{old("shop_status") == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-20">
                                    <a href="{{route("shop.info.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
                                        <span><i class="fa fa-undo"></i>{{__('messages.lbl_btn.btn_back')}}</span>
                                    </a>
                                    <button type="submit" class="button button-sm button-outline button-primary button-long">
                                        <span><i class="fa fa-save"></i>{{__('messages.lbl_btn.btn_save')}}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
