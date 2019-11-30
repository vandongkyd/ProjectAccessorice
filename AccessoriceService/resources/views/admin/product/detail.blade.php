@extends('admin.layout.layout_manage_default')

@section('title', 'Accessories | '.__('messages.lbl_screen_menu.product'))

@section('content-heading')
    <h3 class="title">{{__('messages.lbl_screen_menu.product')}} <span>/ {{__('messages.lbl_header_detail')}}</span></h3>
@stop

@section('after_style')

@stop

@section('content-body')
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <div class="row">
                        <h3 class="title col-lg-10 col-12">{{__('messages.lbl_screen_menu.detail',['name' => __('messages.lbl_screen_menu.product')])}}</h3>
                    </div>
                </div>

                <div class="col-lg-12 col-12 mb-30">
                    <div class="box-body">
                        <div class="row mbn-20">
                            <div class="col-lg-6 col-12 mb-30">
                                <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
                                    @php $default = 0; @endphp
                                    <div class="carousel-inner">
                                        @foreach($product_images as $product_image)
                                            <div class="carousel-item {{$product_images[$default]->sort_no == $product_image->sort_no ? 'active' : '' }}" data-interval="5000">
                                                <img src="{{asset('upload')}}/{{$product_image->file_name}}" alt="">
                                            </div>
                                        @endforeach
                                    </div>

                                    <a class="carousel-control-prev custom-control-prev-next" href="#carouselExampleInterval" data-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next custom-control-prev-next" href="#carouselExampleInterval" data-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                        <span class="sr-only">Next</span>
                                    </a>

                                    <ol class="carousel-indicators" style="position: inherit !important;">
                                        @foreach($product_images as $product_image)
                                            <li data-target="#carouselExampleInterval" data-slide-to="{{$product_image->sort_no}}" class="{{$product_images[$default]->sort_no == $product_image->sort_no ? 'active' : '' }}">
                                                <img src="{{asset('upload')}}/{{$product_image->file_name}}" alt="">
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12 mb-30">
                                <div class="row">
                                    <div class="col-12 mb-20">
                                        <h3>{{__('messages.lbl_table_product.product_name')}}: <span>{{$product->product_name}}</span></h3>

                                        <p>{{__('messages.lbl_table_product.product_code')}}: <span>{{$product->product_code}}</span></p>

                                        <p>{{__('messages.lbl_table_product.category')}}: <span>{{$product->category_name}}</span></p>

                                        <p>{{__('messages.lbl_table_product.product_price')}}: <span>{{ number_format($product->product_price)}} đ</span></p>

                                        <p>{{__('messages.lbl_table_product.product_quality')}}: <span>{{$product->product_quality}}</span></p>

                                        @foreach(__('messages.lbl_status_work') as $key => $value)
                                            @if($key == $product->product_status)
                                                <p>{{__('messages.lbl_table_product.product_status')}}: <span class="pt-2 pb-2 badge badge-outline {{$key == 0 ? 'badge-danger' : 'badge-success'}} pl-15 pr-15">{{$value}}</span></p>
                                            @endif
                                        @endforeach

                                        <p>{{__('messages.lbl_table_product.evaluate')}} <span>
                                                @for ($i = 0; $i < 5; ++$i)
                                                    <i class="fa fa-star{{ $product->product_ratting <= $i ? '-o' : '' }}" aria-hidden="true" style="color: red"></i>
                                                @endfor
                                            </span>
                                        </p>

                                        <p>{{__('messages.lbl_table_product.discount')}}: <span>{{$product->discount_name}}</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12 mb-30">
                                <div class="col-12 mb-20">
                                    <label>{{__('messages.lbl_table_product.product_detail')}}</label>
                                    {!! $product->product_detail !!}
                                </div>
                            </div>

                            <div class="col-lg-12 col-12 mb-30">
                                <div class="col-12 mb-20">
                                    <label>{{__('messages.lbl_table_product.product_description')}}</label>
                                    {!! $product->product_description !!}
                                </div>
                            </div>

                            <div class="col-12 mb-20">
                                <a href="{{route("product.list")}}" role="button" class="button button-sm button-outline button-danger button-long text-center">
                                    <span><i class="fa fa-undo"></i>{{__('messages.lbl_btn.btn_back')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('after_script')
<script>
    $(document).ready(function(){

    });
</script>
@stop