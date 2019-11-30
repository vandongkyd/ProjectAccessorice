@extends('admin.layout.layout_manage_default')


@section('title', 'Accessories | '.__('messages.lbl_screen_menu.user'))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.user')}} <span>/ {{__('messages.lbl_header_list')}}</span></h3>
@stop


@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.user')])}}</h3>
                        <div class="col-lg-2 col-12 text-right">
                            <a href="{{route("user.add")}}" role="button" class="button button-sm button-outline button-primary button-long text-center">
                                <span><i class="fa fa-plus"></i>{{__('messages.lbl_btn.btn_add')}}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-bordered data-table data-table-default table-list text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>{{__('messages.lbl_table_user.avatar')}}</th>
                            <th>{{__('messages.lbl_table_user.full_name')}}</th>
                            <th>{{__('messages.lbl_table_user.user_name')}}</th>
                            <th>{{__('messages.lbl_table_user.email')}}</th>
                            <th>{{__('messages.lbl_table_user.phone')}}</th>
                            <th class="no-sort">{{__('messages.lbl_table_user.status')}}</th>
                            <th>{{__('messages.lbl_table_user.date_create')}}</th>
                            <th width="20%" class="no-sort">{{__('messages.lbl_action_table')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td style="text-align: -webkit-center;">
                                    @if(isset($user->avatar))
                                        <img src="{{asset('upload')}}/{{$user->avatar}}" alt="" class="product-image rounded-circle avatar">
                                    @else
                                        <img src="{{asset('img')}}/{{$user->gender == 0 ? 'icon_men.png' : 'icon_woman.png'}}" alt="" class="product-image rounded-circle avatar">
                                    @endif
                                </td>
                                <td>{{$user->last_name}} {{$user->first_name}}</td>
                                <td>{{$user->user_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                <td>
                                    @foreach(__('messages.lbl_status_user') as $key => $value)
                                        @if($key == $user->status)
                                            <p class="pt-2 pb-2 badge badge-outline @if($key == 0) badge-primary @elseif($key == 1) badge-success @else badge-danger @endif w-75">{{$value}}</p>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{date('d/m/Y', $user->created)}}</td>
                                <td class="text-center">
                                    <button class="button button-sm button-box button-outline button-warning {{$user->id == Auth::user()->id ? 'disabled' : '' }}"
                                            @if($user->id != Auth::user()->id) onclick="popupConfirm('{{$user->id}}','reset')" @endif
                                            data-toggle="tooltip" data-placement="top" title="{{__('messages.lbl_btn.btn_reset')}}">
                                        <i class="fa fa-undo text_white"></i>
                                    </button>
                                    <a href="{{url('admins/user/edit')}}/{{$user->id}}" data-toggle="tooltip" data-placement="top" title="{{__('messages.lbl_btn.btn_edit')}}"
                                       class="button button-sm button-box button-outline button-primary">
                                        <i class="fa fa-pencil-square-o text_white"></i>
                                    </a>
                                    <button class="button button-sm button-box button-outline button-info {{$user->id == Auth::user()->id ? 'disabled' : '' }}"
                                            data-toggle="tooltip" data-placement="top" title="{{$user->status != 2 ? __('messages.lbl_btn.btn_lock') : __('messages.lbl_btn.btn_unlock') }}"
                                            @if($user->id != Auth::user()->id) onclick="popupConfirm('{{$user->id}}','{{$user->status != 2 ? 'lock' : 'unlock'}}')" @endif>
                                        <i class="fa {{$user->status != 2 ? 'fa-lock' : 'fa-unlock' }} text_white"></i>
                                    </button>
                                    <button class="button button-sm button-box button-outline button-danger {{$user->id == Auth::user()->id ? 'disabled' : '' }}"
                                            data-toggle="tooltip" data-placement="top" title="{{__('messages.lbl_btn.btn_delete')}}"
                                            @if($user->id != Auth::user()->id) onclick="popupConfirm('{{$user->id}}','delete')" @endif>
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
    <div class="modal fade" id="modalConfirm">
        <form role="form" id="f_popup" action="{{route('user.submit.delete')}}" method="post">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="title" class="modal-title">{{__('messages.lbl_messages.confirm_delete')}}</h5>
                        <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id_user">
                        <p id="messages">{{__('messages.lbl_messages.msg_confirm_delete',['name' => __('messages.lbl_screen_menu.user')])}}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="button button-outline button-danger button-sm button-short" data-dismiss="modal">
                            <i class="fa fa-close"></i> <span>{{__('messages.lbl_btn.btn_cancel')}}</span>
                        </button>
                        <button type="submit" id="btn_popup" class="button button-outline button-primary button-sm button-short">
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
        // Delete User
        function popupConfirm(id,mod) {
            if (mod == 'delete'){
                $('#f_popup').attr('action', '{{ route('user.submit.delete') }}');
                $('#title').html('{{__('messages.lbl_messages.confirm_delete')}}');
                $('#messages').html('{{__('messages.lbl_messages.msg_confirm_delete',['name' => __('messages.lbl_screen_menu.user')])}}');
                $('#btn_popup').html('<i class="fa fa-trash-o"></i> <span>{{__('messages.lbl_btn.btn_delete')}}</span>');
            }else if (mod == 'lock'){
                $('#f_popup').attr('action', '{{ route('user.submit.lock') }}');
                $('#title').html('{{__('messages.lbl_messages.confirm_lock')}}');
                $('#messages').html('{{__('messages.lbl_messages.msg_confirm_lock',['name' => __('messages.lbl_screen_menu.user')])}}');
                $('#btn_popup').html('<i class="fa fa-lock"></i> <span>{{__('messages.lbl_btn.btn_lock')}}</span>');
            } else if (mod == 'unlock'){
                $('#f_popup').attr('action', '{{ route('user.submit.unlock') }}');
                $('#title').html('{{__('messages.lbl_messages.confirm_unlock')}}');
                $('#messages').html('{{__('messages.lbl_messages.msg_confirm_unlock',['name' => __('messages.lbl_screen_menu.user')])}}');
                $('#btn_popup').html('<i class="fa fa-unlock"></i> <span>{{__('messages.lbl_btn.btn_unlock')}}</span>')
            } else {
                $('#f_popup').attr('action', '{{ route('user.submit.reset') }}');
                $('#title').html('{{__('messages.lbl_messages.confirm_reset')}}');
                $('#messages').html('{{__('messages.lbl_messages.msg_confirm_reset',['name' => __('messages.lbl_screen_menu.user')])}}');
                $('#btn_popup').html('<i class="fa fa-undo"></i> <span>{{__('messages.lbl_btn.btn_reset')}}</span>')
            }
            $('#id_user').val(id);
            $("#modalConfirm").modal('show');
        }
    </script>
@endsection