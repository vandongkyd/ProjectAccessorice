@extends('admin.layout.layout_manage_default')

@section('title', 'Accessories | '.__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.discount')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.discount')}} <span>/ {{__('messages.lbl_header_edit')}}</span></h3>
@stop

@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.discount')])}}</h3>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-30">
                    <div class="box-body">
                        <form id="f_submit" action="{{ route("discount.submit.edit") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mbn-20">
                                <input name="id" type="hidden" value="{{$discount->id}}">
                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="discount_name">{{__('messages.lbl_table_discount.discount_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="discount_name" class="form-control"
                                                   name="discount_name" value="{{old('discount_name',$discount->discount_name)}}"
                                                   placeholder="{{__('messages.lbl_table_discount.discount_name')}}">

                                            @error('discount_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="percent_reduction">{{__('messages.lbl_table_discount.percent_reduction')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="percent_reduction" class="form-control"
                                                   name="percent_reduction" value="{{old('percent_reduction',$discount->percent_reduction)}}"
                                                   placeholder="{{__('messages.lbl_table_discount.percent_reduction')}}">

                                            @error('percent_reduction')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="gift_code">{{__('messages.lbl_table_discount.gift_code')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="gift_code" class="form-control"
                                                   name="gift_code" value="{{old('gift_code',$discount->gift_code)}}"
                                                   placeholder="{{__('messages.lbl_table_discount.gift_code')}}">

                                            @error('gift_code')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="discount_status">{{__('messages.lbl_table_discount.discount_status')}}</label>
                                            <select id="discount_status" class="form-control" name="discount_status">
                                                @foreach(__('messages.lbl_status_list') as $key => $value)
                                                    <option {{old("discount_status",$discount->discount_status) == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-20">
                                    <a href="{{route("discount.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
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