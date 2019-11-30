<div class="side-header show">
    <button class="side-header-close"><i class="fa fa-close"></i></button>
    <div class="side-header-inner custom-scroll">
        <nav class="side-header-menu" id="side-header-menu">
            <ul>
                <li class="{{ Request::is('admins/dashboard') ? 'active' : '' }}">
                    <a href="{{route("dashboard")}}"><i class="fa fa-home"></i> <span>{{__('messages.lbl_screen_menu.dashboard')}}</span></a>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/banner*') ? 'active' : '' }}"><a href="#"><i class="fa fa-tv"></i> <span>{{__('messages.lbl_screen_menu.banner')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/banner*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/banner/list') ? 'active' : '' }}">
                            <a href="{{route("banner.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.banner')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/banner/add') ? 'active' : '' }}">
                            <a href="{{route("banner.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.banner')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/brand*') ? 'active' : '' }}"><a href="#"><i class="fa fa-bars"></i> <span>{{__('messages.lbl_screen_menu.brand')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/brand*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/brand/list') ? 'active' : '' }}">
                            <a href="{{route("brand.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.brand')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/brand/add') ? 'active' : '' }}">
                            <a href="{{route("brand.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.brand')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/product-category/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-cube"></i> <span>{{__('messages.lbl_screen_menu.product_category')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/product-category/*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/product-category/list') ? 'active' : '' }}">
                            <a href="{{route("product.category.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.product_category')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/product-category/add') ? 'active' : '' }}">
                            <a href="{{route("product.category.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.product_category')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/product/*') ? 'active' : '' }}"><a href="#"><i class="fa fa-cubes"></i> <span>{{__('messages.lbl_screen_menu.product')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/product/*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/product/list') ? 'active' : '' }}">
                            <a href="{{route("product.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.product')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/product/add') ? 'active' : '' }}">
                            <a href="{{route("product.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.product')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/discount*') ? 'active' : '' }}"><a href="#"><i class="fa fa-percent"></i> <span>{{__('messages.lbl_screen_menu.discount')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/discount*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/discount/list') ? 'active' : '' }}">
                            <a href="{{route("discount.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.discount')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/discount/add') ? 'active' : '' }}">
                            <a href="{{route("discount.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.discount')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/ship-type*') ? 'active' : '' }}"><a href="#"><i class="fa fa-truck"></i> <span>{{__('messages.lbl_screen_menu.ship')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/ship-type*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/ship-type/list') ? 'active' : '' }}">
                            <a href="{{route("ship.type.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.ship')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/ship-type/add') ? 'active' : '' }}">
                            <a href="{{route("ship.type.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.ship')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/invoice*') ? 'active' : '' }}"><a href="#"><i class="fa fa-file-text"></i> <span>{{__('messages.lbl_screen_menu.invoice')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/invoice*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/invoice/list') ? 'active' : '' }}">
                            <a href="{{route("invoice.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.invoice')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/invoice/add') ? 'active' : '' }}">
                            <a href="{{route("invoice.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.invoice')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/customer*') ? 'active' : '' }}"><a href="#"><i class="fa fa-users"></i> <span>{{__('messages.lbl_screen_menu.customers')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/customer*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/customer/list') ? 'active' : '' }}">
                            <a href="{{route("customer.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.customers')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/customer/add') ? 'active' : '' }}">
                            <a href="{{route("customer.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.customers')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/shop.info*') ? 'active' : '' }}"><a href="#"><i class="fa fa-info"></i> <span>{{__('messages.lbl_screen_menu.shopinfo')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/shop.info*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/shop.info/list') ? 'active' : '' }}">
                            <a href="{{route("shop.info.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.shopinfo')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/shop.info/add') ? 'active' : '' }}">
                            <a href="{{route("shop.info.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.shopinfo')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub-menu {{ Request::is('admins/user*') ? 'active' : '' }}"><a href="#"><i class="fa fa-user-md"></i> <span>{{__('messages.lbl_screen_menu.user')}}</span></a>
                    <ul class="side-header-sub-menu {{ Request::is('admins/user*') ? 'display-block' : '' }}">
                        <li class="{{ Request::is('admins/user/list') ? 'active' : '' }}">
                            <a href="{{route("user.list")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.list',['name' => __('messages.lbl_screen_menu.user')])}}</span></a>
                        </li>
                        <li class="{{ Request::is('admins/user/add') ? 'active' : '' }}">
                            <a href="{{route("user.add")}}"><i class="fa fa-circle nav-icon"></i><span>{{__('messages.lbl_screen_menu.create',['name' => __('messages.lbl_screen_menu.user')])}}</span></a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{route("admin.logout")}}" onclick="document.getElementById('frm-logout').submit();"><i class="fa fa-sign-out"></i> <span>{{__('messages.lbl_screen_menu.logout')}}</span></a>
                    <form id="logout-form" action="{{ url('admins/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</div>