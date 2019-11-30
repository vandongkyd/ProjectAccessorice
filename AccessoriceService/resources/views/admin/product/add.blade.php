@extends('admin.layout.layout_manage_default')

@section('title', 'Accessories | '.__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.product')]))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.product')}} <span>/ {{__('messages.lbl_header_add')}}</span></h3>
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
                        <form id="f_submit" action="{{ route("product.submit.add") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mbn-20">
                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="product_code">{{__('messages.lbl_table_product.product_code')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="product_code" class="form-control"
                                                   name="product_code" value="{{old('product_code')}}"
                                                   placeholder="{{__('messages.lbl_table_product.product_code')}}">

                                            @error('product_code')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="product_name">{{__('messages.lbl_table_product.product_name')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="product_name" class="form-control"
                                                   name="product_name" value="{{old('product_name')}}"
                                                   placeholder="{{__('messages.lbl_table_product.product_name')}}">

                                            @error('product_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="category">{{__('messages.lbl_table_product.category')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="category" class="form-control select2" name="category">
                                                <option value="">Select {{__('messages.lbl_table_product.category')}}</option>
                                                @foreach($categories as $category)
                                                    <option {{old("category") == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-30">
                                    <div class="row mbn-20">
                                        <div class="col-12 mb-20">
                                            <label for="product_price">{{__('messages.lbl_table_product.product_price')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="text" id="product_price" class="form-control"
                                                   name="product_price" value="{{old('product_price')}}"
                                                   placeholder="{{__('messages.lbl_table_product.product_price')}}">

                                            @error('product_price')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="product_quality">{{__('messages.lbl_table_product.product_quality')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <input type="number" id="product_quality" class="form-control"
                                                   name="product_quality" value="{{old('product_quality')}}"
                                                   placeholder="{{__('messages.lbl_table_product.product_quality')}}">

                                            @error('product_quality')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-20">
                                            <label for="discount">{{__('messages.lbl_table_product.discount')}} <i class="fa fa-asterisk color-red"></i></label>
                                            <select id="discount" class="form-control select2" name="discount">
                                                <option value="">Select {{__('messages.lbl_table_product.discount')}}</option>
                                                @foreach($discounts as $discount)
                                                    <option {{old("discount") == $discount->id ? 'selected' : ''}} value="{{$discount->id}}">{{$discount->discount_name}}</option>
                                                @endforeach
                                            </select>

                                            @error('discount')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-20">
                                    <div class="product-upload-gallery row flex-wrap">
                                        <div class="col-12 mb-30">
                                            <label>{{__('messages.lbl_table_product.product_img')}} <i class="fa fa-asterisk color-red"></i></label>

                                            <div class="progress" id="progress" style="display: none;">
                                                <div id="progress-bar" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <label class="div-img" for="upload_file">
                                                <input id="upload_file" name="upload_file" type="file" accept="image/*" style="display: none" onchange="add_images(this);" multiple>
                                                <i class="fa fa-cloud-upload div-img-i"></i>
                                            </label>
                                            @error('upload_file')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                            <div id="image_preview">
                                                @if(count(old('images_product')) != 0 )
                                                    @for ($i = 0; $i < count(old('images_product')); $i++)
                                                        <div class="div-image-preview" data-imgname="{{old('images_product.'. $i)}}" style="background-image: url({{asset('upload_temp'.'/'. old('images_product.'. $i) )}});">
                                                            <button type="button" class="btn-close-preview"><i class="fa fa-close"></i></button>
                                                            <input type="hidden" name="images_product[]" value="{{old('images_product.'. $i)}}">
                                                        </div>
                                                    @endfor
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-12 mb-30">
                                    <label for="date_start">{{__('messages.lbl_table_product.date_start')}}</label>
                                    <input type="text" class="form-control input-date-single" name="date_start" id="date_start" value="{{old('date_start')}}">
                                </div>
                                <div class="col-lg-6 col-12 mb-30">
                                    <label for="date_end">{{__('messages.lbl_table_product.date_end')}}</label>
                                    <input type="text" class="form-control input-date-single" name="date_end" id="date_end" value="{{old('date_end')}}">

                                    @error('date_end')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-20">
                                    <label for="product_detail">{{__('messages.lbl_table_product.product_detail')}} <i class="fa fa-asterisk color-red"></i></label>
                                    <textarea id="product_detail" name="product_detail" class="summernote_small">{{old('product_detail')}}</textarea>
                                    @error('product_detail')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-20">
                                    <label for="product_description">{{__('messages.lbl_table_product.product_description')}} <i class="fa fa-asterisk color-red"></i></label>
                                    <textarea id="product_description" name="product_description" class="summernote">{{old('product_description')}}</textarea>
                                    @error('product_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-6 mb-20">
                                    <label for="product_status">{{__('messages.lbl_table_product.product_status')}}</label>
                                    <select id="product_status" class="form-control" name="product_status">
                                        @foreach(__('messages.lbl_status_work') as $key => $value)
                                            <option {{old("product_status") == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-20">
                                    <a href="{{route("product.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
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

@section('after_script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function add_images(img) {
            for (let i = 0; i < img.files.length; i++ ){
                const form_data = new FormData();
                form_data.append('file', img.files[i]);
                $('#progress').css('display','-webkit-box');
                const elem = document.getElementById("progress-bar");
                let width = 1;
                const id = setInterval(frame, 15);
                function frame() {
                    if (width >= 100) {
                        $.ajax({
                            url: "{{route('product.submit.add.image')}}",
                            data: form_data,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if (!data.fail) {
                                    var path = '{{ asset('upload_temp') }}/' + data;
                                    $('#image_preview').append("<div class='div-image-preview' data-imgname='"+ data +"' style=\"background-image: url("+ path +");\">" +
                                        "<button type='button' class='btn-close-preview'><i class='fa fa-close'></i></button>" +
                                        "<input type='hidden' name='images_product[]' value='" + data + "'>" +
                                        "</div>");
                                    $('#progress').css('display','none');
                                    elem.style.width = 0 + '%';
                                    $(".div-image-preview" ).bind("click", function(e) {
                                        removeImage($(this));
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                $('#progress').css('display','none');
                                elem.style.width = 0 + '%';
                                alert(error);
                            }
                        });
                        clearInterval(id);
                    } else {
                        width++;
                        elem.style.width = width + '%';
                    }
                }
            }
        }

        $('.div-image-preview').on('click',function (e) {
            removeImage($(this));
        });


        function removeImage(this_tag) {
            const this_div = this_tag;
            const file_name = this_tag.data('imgname');
            const form_data = new FormData();
            form_data.append('file_name', file_name);
            $('#progress').css('display','-webkit-box');
            const elem = document.getElementById("progress-bar");
            let width = 1;
            const id = setInterval(frame, 2);
            function frame() {
                if (width >= 100) {
                    $.ajax({
                        url: "{{ route('product.submit.delete.image') }}",
                        data: form_data,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            if (!data.fail) {
                                $('#progress').css('display','none');
                                elem.style.width = 0 + '%';
                                this_div.remove();
                            }
                        }
                    });
                    clearInterval(id);
                } else {
                    width++;
                    elem.style.width = width + '%';
                }
            }
        }
    </script>
@stop

