@extends('admin.layout.layout_manage_default')

@section('title', 'Accessories | '.__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.brand')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.brand')}} <span>/ {{__('messages.lbl_header_edit')}}</span></h3>
@stop

@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.brand')])}}</h3>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-30">
                    <div class="box-body">
                        <form id="f_submit" action="{{ route("brand.submit.edit") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mbn-20">
                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <input type="hidden" name="id" value="{{$brand->id}}">
                                        <div class="col-12 mb-20">
                                            <label for="brand_name">{{__('messages.lbl_table_brand.brand_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="brand_name" class="form-control"
                                                   name="brand_name" value="{{old('brand_name',$brand->brand_name)}}"
                                                   placeholder="{{__('messages.lbl_table_brand.brand_name')}}">

                                            @error('brand_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="discount_id">{{__('messages.lbl_table_brand.discount_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="discount_id" class="form-control select2" name="discount_id">
                                                <option value="">Select {{__('messages.lbl_table_brand.discount_name')}}</option>
                                                @foreach($discounts as $discount)
                                                    <option {{old("discount_id",$brand->discount_id) == $discount->id ? 'selected' : ''}} value="{{$discount->id}}">{{$discount->discount_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('discount_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="brand_status">{{__('messages.lbl_table_brand.brand_status')}}</label>
                                            <select id="brand_status" class="form-control" name="brand_status">
                                                @foreach(__('messages.lbl_status_work') as $key => $value)
                                                    <option {{old("brand_status",$brand->brand_status) == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="brand_image">{{__('messages.lbl_table_brand.brand_image')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="file" id="brand_image" class="dropify" name="brand_image" accept="image/*"
                                                   data-default-file="{{asset('upload')}}/{{$brand->brand_img}}">

                                            @error('brand_image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-20">
                                    <a href="{{route("brand.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
                                        <span><i class="fa fa-undo"></i>{{__('messages.lbl_btn.btn_back')}}</span>
                                    </a>
                                    <button type="submit" class="button button-sm button-outline button-primary button-long">
                                        <span><i class="fa fa-refresh"></i>{{__('messages.lbl_btn.btn_update')}}</span>
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