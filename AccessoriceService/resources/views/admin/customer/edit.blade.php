@extends('admin.layout.layout_manage_default')


@section('title', 'Accessories | '.__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.customers')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.customers')}} <span>/ {{__('messages.lbl_header_edit')}}</span></h3>
@stop


@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.customers')])}}</h3>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-30">
                    <div class="box-body">
                        <form id="f_submit" action="{{ route("customer.submit.edit") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mbn-20">
                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <input name="id" value="{{$customer->id}}" type="hidden">
                                        <div class="col-12 mb-20">
                                            <label for="last_name">{{__('messages.lbl_table_customer.last_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="last_name" class="form-control"
                                                   name="last_name" value="{{old('last_name',$customer->last_name)}}"
                                                   placeholder="{{__('messages.lbl_table_customer.last_name')}}">

                                            @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="user_name">{{__('messages.lbl_table_customer.user_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="user_name" class="form-control" readonly
                                                   name="user_name" value="{{old('user_name',$customer->user_name)}}"
                                                   placeholder="{{__('messages.lbl_table_customer.user_name')}}">

                                            @error('user_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="phone">{{__('messages.lbl_table_customer.phone')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="phone" class="form-control"
                                                   name="phone" value="{{old('phone',$customer->phone)}}"
                                                   placeholder="{{__('messages.lbl_table_customer.phone')}}">

                                            @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="language">{{__('messages.lbl_table_customer.language')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="language" class="form-control" name="language">
                                                <option value=""></option>
                                                @foreach(__('messages.lbl_languages_list') as $key => $value)
                                                    <option {{old("language",$customer->language) == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>

                                            @error('language')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="gender">{{__('messages.lbl_table_customer.gender')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <div class="adomx-checkbox-radio-group inline mt-5">
                                                @foreach(__('messages.lbl_gender_list') as $key => $value)
                                                    <label class="adomx-radio-2 w-40">
                                                        <input {{old('gender',$customer->gender) == $key ? 'checked' : ''}} type="radio" value="{{$key}}" name="gender">
                                                        <i class="icon"></i> {{$value}}
                                                    </label>
                                                @endforeach
                                            </div>

                                            @error('gender')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="first_name">{{__('messages.lbl_table_customer.first_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="first_name" class="form-control"
                                                   name="first_name" value="{{old('first_name',$customer->first_name)}}"
                                                   placeholder="{{__('messages.lbl_table_customer.first_name')}}">

                                            @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="email">{{__('messages.lbl_table_customer.email')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="email" class="form-control"
                                                   name="email" value="{{old('email',$customer->email)}}"
                                                   placeholder="{{__('messages.lbl_table_customer.email')}}">

                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="status">{{__('messages.lbl_table_customer.status')}}</label>
                                            <select id="status" class="form-control" name="status">
                                                @foreach(__('messages.lbl_status_user') as $key => $value)
                                                    <option {{old("status",$customer->status) == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-20">
                                    <label for="address">{{__('messages.lbl_table_customer.address')}} <i class="fa fa-asterisk color-red"></i></label>
                                    <textarea class="form-control" id="address" name="address" placeholder="{{__('messages.lbl_table_customer.address')}}">{{old('address',$customer->address)}}</textarea>
                                    @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-20">
                                    <a href="{{route("customer.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
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