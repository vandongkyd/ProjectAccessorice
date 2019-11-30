@extends('admin.layout.layout_manage_default')

@section('title', 'Accessories | '.__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.product_category')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.product_category')}} <span>/ {{__('messages.lbl_header_add')}}</span></h3>
@stop

@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.product_category')])}}</h3>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-30">
                    <div class="box-body">
                        <form id="f_submit" action="{{ route("product.category.submit.add") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mbn-20">
                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="category_name">{{__('messages.lbl_table_category.category_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="category_name" class="form-control"
                                                   name="category_name" value="{{old('category_name')}}"
                                                   placeholder="{{__('messages.lbl_table_category.category_name')}}">

                                            @error('category_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="brand">{{__('messages.lbl_table_category.brand')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="brand" class="form-control select2" name="brand">
                                                <option value="">Select {{__('messages.lbl_table_category.brand')}}</option>
                                                @foreach($brands as $brand)
                                                    <option {{old("brand") == $brand->id ? 'selected' : ''}} value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('brand')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="discount">{{__('messages.lbl_table_category.discount')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="discount" class="form-control select2" name="discount">
                                                <option value="">Select {{__('messages.lbl_table_category.discount')}}</option>
                                                @foreach($discounts as $discount)
                                                    <option {{old("discount") == $discount->id ? 'selected' : ''}} value="{{$discount->id}}">{{$discount->discount_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('discount')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="category_status">{{__('messages.lbl_table_category.category_status')}}</label>
                                            <select id="category_status" class="form-control" name="category_status">
                                                @foreach(__('messages.lbl_status_work') as $key => $value)
                                                    <option {{old("category_status") == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-20">
                                    <a href="{{route("product.category.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
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
