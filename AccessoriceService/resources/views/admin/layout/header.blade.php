<div class="header-section">
    <div class="container-fluid">
        <div class="row justify-content-between align-items-center">
            <!-- Header Logo (Header Left) Start -->
            <div class="header-logo col-auto">
                <a href="{{route('dashboard')}}">
                    <img src="{{ asset('img/project_logo.png')}}" alt="">
                    <img src="{{ asset('img/project_logo.png')}}" class="logo-light" alt="">
                </a>
            </div>

            <!-- Header Right Start -->
            <div class="header-right flex-grow-1 col-auto">
                <div class="row justify-content-between align-items-center">

                    <!-- Side Header Toggle & Search Start -->
                    <div class="col-auto">
                        <div class="row align-items-center">
                            <div class="col-auto"><button class="side-header-toggle"><i class="fa fa-bars"></i></button></div>
                        </div>
                    </div>

                    <!-- Header Notifications Area Start -->
                    <div class="col-auto">
                        <ul class="header-notification-area">
                            <!--Language-->
                            <li class="adomx-dropdown position-relative col-auto">
                                <a class="toggle" href="#"><img class="lang-flag" src="{{asset('flag')}}/{{Auth::user()->language}}.png" alt=""> <i class="fa fa-caret-down ml-1"></i></a>

                                <!-- Dropdown -->
                                <ul class="adomx-dropdown-menu dropdown-menu-language">
                                    @foreach(__('messages.lbl_languages_list') as $key => $value)
                                        <li>
                                            <a href="#" onclick="document.getElementById('f_change{{$key}}').submit();"><img src="{{asset('flag')}}/{{$key}}.png" alt=""> {{$value}}</a>
                                            <form id="f_change{{$key}}" action="{{ route('user.submit.change.language') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input name="id" type="hidden" value="{{Auth::user()->id}}">
                                                <input name="language" type="hidden" value="{{$key}}">
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                            <!--Mail-->
                            <li class="adomx-dropdown col-auto">
                                <a class="toggle" href="#"><i class="fa fa-envelope-o"></i><span class="badge"></span></a>

                                <!-- Dropdown -->
                                <div class="adomx-dropdown-menu dropdown-menu-mail">
                                    <div class="head">
                                        <h4 class="title">You have 3 new mail.</h4>
                                    </div>
                                    <div class="body custom-scroll">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <div class="image"><img src="{{asset('upload')}}/{{Auth::user()->avatar}}" alt=""></div>
                                                    <div class="content">
                                                        <h6>Sub: New Account</h6>
                                                        <p>There are many variations of passages of Lorem Ipsum available. </p>
                                                    </div>
                                                    <span class="reply"><i class="fa fa-mail-reply"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </li>

                            <!--Notification-->
                            <li class="adomx-dropdown col-auto">
                                <a class="toggle" href="#"><i class="fa fa-bell-o"></i><span class="badge"></span></a>

                                <!-- Dropdown -->
                                <div class="adomx-dropdown-menu dropdown-menu-notifications">
                                    <div class="head">
                                        <h5 class="title">You have 4 new notification.</h5>
                                    </div>
                                    <div class="body custom-scroll">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-notifications-none"></i>
                                                    <p>There are many variations of pages available.</p>
                                                    <span>11.00 am   Today</span>
                                                </a>
                                                <button class="delete"><i class="fa fa-times-circle-o"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="footer">
                                        <a href="#" class="view-all">view all</a>
                                    </div>
                                </div>

                            </li>

                            <!--User-->
                            <li class="adomx-dropdown col-auto">
                                <a class="toggle" href="#">
                                            <span class="user">
                                        <span class="avatar">
                                            <img src="{{asset('upload')}}/{{Auth::user()->avatar}}" alt="">
                                            <span class="status"></span>
                                            </span>
                                            <span class="name">{{Auth::user()->first_name}}</span>
                                            </span>
                                </a>

                                <!-- Dropdown -->
                                <div class="adomx-dropdown-menu dropdown-menu-user">
                                    <div class="body">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-user-circle"></i>{{Auth::user()->first_name}}</a></li>
                                            <li><a class="mail"><i class="fa fa-envelope-o"></i>{{Auth::user()->email}}</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="#"><i class="fa fa-drivers-license-o"></i>Profile</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="#"><i class="fa fa-gear"></i>Setting</a></li>
                                            <li>
                                                <a href="{{route("admin.logout")}}" onclick="document.getElementById('frm-logout').submit();"><i class="fa fa-sign-out"></i>Sing out</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>