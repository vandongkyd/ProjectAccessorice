@extends('admin.layout.layout_manage_default')

@section('title', 'Accessories | '.__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.banner')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.banner')}} <span>/ {{__('messages.lbl_header_add')}}</span></h3>
@stop

@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.banner')])}}</h3>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-30">
                    <div class="box-body">
                        <form id="f_submit" action="{{ route("banner.submit.add") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mbn-20">
                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="banner_name">{{__('messages.lbl_table_banner.banner_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="banner_name" class="form-control"
                                                   name="banner_name" value="{{old('banner_name')}}"
                                                   placeholder="{{__('messages.lbl_table_banner.banner_name')}}">

                                            @error('banner_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="product">{{__('messages.lbl_table_banner.product')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="product" class="form-control select2" name="product">
                                                <option value="">Select {{__('messages.lbl_table_banner.product')}}</option>
                                                @foreach($products as $product)
                                                    <option {{old("product") == $product->id ? 'selected' : ''}} value="{{$product->id}}">{{$product->product_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('product')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="category">{{__('messages.lbl_table_banner.category')}}</label>
                                            <select id="category" class="form-control select2" name="category">
                                                <option value="">Select {{__('messages.lbl_table_banner.category')}}</option>
                                                @foreach($categories as $category)
                                                    <option {{old("category") == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="date_start">{{__('messages.lbl_table_banner.date_start')}}</label>
                                            <input type="text" class="form-control input-date-single" name="date_start" id="date_start" value="{{old('date_start')}}">
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="banner_image">{{__('messages.lbl_table_banner.banner_image')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="file" id="banner_image" class="dropify" name="banner_image"
                                                   data-default-file="{{old("banner_image")}}" accept="image/*">

                                            @error('banner_image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="date_end">{{__('messages.lbl_table_banner.date_end')}}</label>
                                            <input type="text" class="form-control input-date-single" name="date_end" id="date_end" value="{{old('date_end')}}">

                                            @error('date_end')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-20">
                                    <label for="banner_description">{{__('messages.lbl_table_banner.banner_description')}}</label>
                                    <textarea id="banner_description" name="banner_description" class="summernote_small">{{old('banner_description')}}</textarea>
                                </div>

                                <div class="col-6 mb-20">
                                    <label for="banner_status">{{__('messages.lbl_table_banner.banner_status')}}</label>
                                    <select id="banner_status" class="form-control" name="banner_status">
                                        @foreach(__('messages.lbl_status_work') as $key => $value)
                                            <option {{old("banner_status") == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                         @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-20">
                                    <a href="{{route("banner.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
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

    {{--<button onclick="notifySuccess('dongtest', Number(2000));" class="btn btn-danger">Test Notification</button>--}}
    {{--<button onclick="notifyError('dongtest', Number(2000));" class="btn btn-danger">Notification</button>--}}
@stop

@section('after_script')

@endsection
