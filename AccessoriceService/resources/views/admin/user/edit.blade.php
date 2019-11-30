@extends('admin.layout.layout_manage_default')

@section('title', 'Accessories | '.__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.user')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.user')}} <span>/ {{__('messages.lbl_header_edit')}}</span></h3>
@stop

@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.user')])}}</h3>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-30">
                    <div class="box-body">
                        <form id="f_submit" action="{{ route("user.submit.edit") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mbn-20">
                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <input name="id" value="{{$user->id}}" type="hidden">
                                        <div class="col-12 mb-20">
                                            <label for="last_name">{{__('messages.lbl_table_user.last_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="last_name" class="form-control"
                                                   name="last_name" value="{{old('last_name',$user->last_name)}}"
                                                   placeholder="{{__('messages.lbl_table_user.last_name')}}">

                                            @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="user_name">{{__('messages.lbl_table_user.user_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="user_name" class="form-control" readonly
                                                   name="user_name" value="{{old('user_name',$user->user_name)}}"
                                                   placeholder="{{__('messages.lbl_table_user.user_name')}}">

                                            @error('user_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="phone">{{__('messages.lbl_table_user.phone')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="phone" class="form-control"
                                                   name="phone" value="{{old('phone',$user->phone)}}"
                                                   placeholder="{{__('messages.lbl_table_user.phone')}}">

                                            @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="language">{{__('messages.lbl_table_user.language')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="language" class="form-control" name="language">
                                                <option value=""></option>
                                                @foreach(__('messages.lbl_languages_list') as $key => $value)
                                                    <option {{old("language",$user->language) == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>

                                            @error('language')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="gender">{{__('messages.lbl_table_user.gender')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <div class="adomx-checkbox-radio-group inline mt-5">
                                                @foreach(__('messages.lbl_gender_list') as $key => $value)
                                                    <label class="adomx-radio-2 w-40">
                                                        <input {{old('gender',$user->gender) == $key ? 'checked' : ''}} type="radio" value="{{$key}}" name="gender">
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
                                            <label for="first_name">{{__('messages.lbl_table_user.first_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="first_name" class="form-control"
                                                   name="first_name" value="{{old('first_name',$user->first_name)}}"
                                                   placeholder="{{__('messages.lbl_table_user.first_name')}}">

                                            @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="email">{{__('messages.lbl_table_user.email')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="email" class="form-control"
                                                   name="email" value="{{old('email',$user->email)}}"
                                                   placeholder="{{__('messages.lbl_table_user.email')}}">

                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="shop_id">{{__('messages.lbl_table_user.shop_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="shop_id" class="form-control" name="shop_id">
                                                <option value=""></option>
                                                @foreach($shops as $shop)
                                                    <option {{old("shop_id",$user->shop_id) == $shop->id ? 'selected' : ''}} value="{{$shop->id}}">{{$shop->shop_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('shop_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="role_id">{{__('messages.lbl_table_user.role')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="role_id" class="form-control" name="role_id">
                                                <option value=""></option>
                                                @foreach(__('messages.lbl_role_list') as $key => $value)
                                                    <option {{old("role_id",$user->role_id) == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>

                                            @error('role_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="status">{{__('messages.lbl_table_user.status')}}</label>
                                            <select id="status" class="form-control" name="status">
                                                @foreach(__('messages.lbl_status_user') as $key => $value)
                                                    <option {{old("status",$user->status) == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-20">
                                    <label for="address">{{__('messages.lbl_table_user.address')}} <i class="fa fa-asterisk color-red"></i></label>
                                    <textarea class="form-control" id="address" name="address" placeholder="{{__('messages.lbl_table_user.address')}}">{{old('address',$user->address)}}</textarea>
                                    @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-20">
                                    <a href="{{route("user.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
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