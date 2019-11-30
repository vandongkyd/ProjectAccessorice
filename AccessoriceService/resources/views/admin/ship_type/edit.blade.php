@extends('admin.layout.layout_manage_default')

@section('title', 'Accessories | '.__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.ship')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.ship')}} <span>/ {{__('messages.lbl_header_edit')}}</span></h3>
@stop

@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.edit',['name' => __('messages.lbl_screen_menu.ship')])}}</h3>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-30">
                    <div class="box-body">
                        <form id="f_submit" action="{{ route("ship.type.submit.edit") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mbn-20">
                                <div class="col-lg-6 col-12 mb-30">
                                    <input name="id" value="{{$ship->id}}" type="hidden">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="ship_name">{{__('messages.lbl_table_ship.ship_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="ship_name" class="form-control"
                                                   name="ship_name" value="{{old('ship_name',$ship->ship_name)}}"
                                                   placeholder="{{__('messages.lbl_table_ship.ship_name')}}">

                                            @error('ship_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="ship_price">{{__('messages.lbl_table_ship.ship_price')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="ship_price" class="form-control"
                                                   name="ship_price" value="{{old('ship_price',$ship->ship_price)}}"
                                                   placeholder="{{__('messages.lbl_table_ship.ship_price')}}">

                                            @error('ship_price')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="ship_status">{{__('messages.lbl_table_ship.ship_status')}}</label>
                                            <select id="ship_status" class="form-control" name="ship_status">
                                                @foreach(__('messages.lbl_status_list') as $key => $value)
                                                    <option {{old("ship_status",$ship->ship_status) == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-20">
                                    <a href="{{route("ship.type.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
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