@extends('admin.layout.layout_manage_default')

@section('title', 'Accessories | '.__('messages.lbl_screen_menu.banner'))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.banner')}} <span>/ {{__('messages.lbl_header_list')}}</span></h3>
@stop

@section('content-body')
    <div class="row">
        <!--Default Data Table Start-->
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.banner')])}}</h3>
                        <div class="col-lg-2 col-12 text-right">
                            <a href="{{route("banner.add")}}" role="button" class="button button-sm button-outline button-primary button-long text-center">
                                <span><i class="fa fa-plus"></i>{{__('messages.lbl_btn.btn_add')}}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered data-table data-table-default table-list text-center ">
                        <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th class="no-sort">{{__('messages.lbl_table_banner.banner_image')}}</th>
                            <th>{{__('messages.lbl_table_banner.banner_name')}}</th>
                            <th>{{__('messages.lbl_table_banner.product')}}</th>
                            <th>{{__('messages.lbl_table_banner.category')}}</th>
                            <th class="no-sort">{{__('messages.lbl_table_banner.banner_status')}}</th>
                            <th>{{__('messages.lbl_table_banner.date_create')}}</th>
                            <th class="no-sort">{{__('messages.lbl_action_table')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($banners as $banner)
                            <tr>
                                <td>{{$banner->id}}</td>
                                <td><img src="{{asset('upload')}}/{{$banner->banner_img}}" style="width: 120px; height: 70px;" alt=""></td>
                                <td>{{$banner->banner_name}}</td>
                                <td>{{$banner->product_id}}</td>
                                <td>{{$banner->category_id}}</td>
                                <td>
                                    @foreach(__('messages.lbl_status_work') as $key => $value)
                                        @if($key == $banner->banner_status)
                                            <p class="pt-2 pb-2 badge badge-outline {{$key == 0 ? 'badge-danger' : 'badge-success'}} w-75">{{$value}}</p>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{date('d/m/Y', $banner->created)}}</td>
                                <td class="text-center">
                                    <a href="{{url('admins/banner/edit')}}/{{$banner->id}}" data-toggle="tooltip" data-placement="top" title="{{__('messages.lbl_btn.btn_edit')}}"
                                       class="button button-sm button-box button-outline button-primary">
                                        <i class="fa fa-pencil-square-o text_white"></i>
                                    </a>
                                    <button class="button button-sm button-box button-outline button-danger" onclick="deleteBanner({{$banner->id}})"
                                            data-toggle="tooltip" data-placement="top" title="{{__('messages.lbl_btn.btn_delete')}}">
                                        <i class="fa fa-trash-o text_white"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('modal')
    <div class="modal fade" id="modalBanner">
        <form role="form" action="{{route('banner.submit.delete')}}" method="post">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__('messages.lbl_messages.confirm_delete')}}</h5>
                        <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="banner_id">
                        <p>{{__('messages.lbl_messages.msg_confirm_delete',['name' => __('messages.lbl_screen_menu.banner')])}}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="button button-outline button-danger button-sm button-short" data-dismiss="modal">
                            <i class="fa fa-close"></i> <span>{{__('messages.lbl_btn.btn_cancel')}}</span>
                        </button>
                        <button type="submit" class="button button-outline button-primary button-sm button-short">
                            <i class="fa fa-trash-o"></i> <span>{{__('messages.lbl_btn.btn_delete')}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('after_script')
    <script>
        // Delete Banner
        function deleteBanner(id) {
            $('#banner_id').val(id);
            $("#modalBanner").modal('show');
        }
    </script>
@endsection