{{--@extends('layout.app')--}}

{{--@section('title', 'Accessories | '.__('messages.lbl_title_login'))--}}

{{--@section('block content')--}}
    {{--<canvas id="canvas"></canvas>--}}
    {{--<div class="limiter">--}}
        {{--<div class="container-login100">--}}
            {{--<div class="wrap-login100">--}}
                {{--<form class="login100-form validate-form" action="{{ route('login')}}" autocomplete="off"--}}
                      {{--method="post">--}}
                    {{--@csrf--}}
                    {{--<span class="login100-form-logo">--}}
						{{--<img class="img_logo" style="padding: 0 15px" src="{{asset('/img/project_logo.png')}}"--}}
                             {{--alt=""/>--}}
					{{--</span>--}}
                    {{--<span class="login100-form-title p-b-10 p-t-17">--}}
						{{--{{ __('messages.lbl_title_login') }}--}}
					{{--</span>--}}

                    {{--Login ID--}}
                    {{--<div class="mr-top-bottom-10 has-feedback">--}}
                        {{--<div class="wrap-input100 validate-input" id="username" data-validate="Enter Login ID">--}}
                            {{--<label class="input-labels" for="user_name"><i class="fa fa-user"></i> Login ID</label>--}}
                            {{--<input type="text" class="formInput input100" id="user_name" name="username">--}}

                            {{--@error('username')--}}
                            {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                            {{--@enderror--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--Password--}}
                    {{--<div class="mr-top-bottom-10 has-feedback">--}}
                        {{--<div class="wrap-input100 validate-input" id="password" data-validate="Enter Password">--}}
                            {{--<label class="input-labels" for="show_password"><i class="fa fa-lock"></i> Password</label>--}}
                            {{--<input type="password" class="formInput input100" id="show_password" name="password">--}}

                            {{--@error('password')--}}
                            {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                            {{--@enderror--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--Display Show Password--}}
                    {{--<div class="contact100-form-checkbox">--}}
                        {{--<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me"--}}
                               {{--onchange="togglePassword()">--}}
                        {{--<label class="label-checkbox100" for="ckb1">--}}
                            {{--{{__('messages.lbl_display_password')}}--}}
                        {{--</label>--}}
                    {{--</div>--}}

                    {{--<div class="container-login100-form-btn">--}}
                        {{--<button type="submit" class="login100-form-btn">--}}
                            {{--{{__('messages.lbl_title_login')}}--}}
                        {{--</button>--}}
                    {{--</div>--}}

                    {{--<div class="text-center p-t-30">--}}
                        {{--<a class="txt1" href="{{url('/forgot-password')}}">--}}
                            {{--Forgot Password?--}}
                        {{--</a>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

{{--@endsection--}}

{{--@section('after_script')--}}
    {{--<script>--}}
        {{--function togglePassword() {--}}
            {{--let x = document.getElementById("show_password");--}}
            {{--if (x.type === "password") {--}}
                {{--x.type = "text";--}}
            {{--} else {--}}
                {{--x.type = "password";--}}
            {{--}--}}
        {{--}--}}
    {{--</script>--}}
{{--@stop--}}
