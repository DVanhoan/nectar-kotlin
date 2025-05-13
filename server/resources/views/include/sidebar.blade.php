<div class="section-menu-left">
    <div class="box-logo">
        <a href="{{route('dashboard')}}" id="site-logo-inner">
            <img class="" id="logo_header_1" alt="" src="{{ asset('images/logo/logo.png') }}">
        </a>
        <div class="button-show-hide">
            <i class="icon-menu-left"></i>
        </div>
    </div>
    <div class="center">
        <div class="center-item">
            <div class="center-heading">Main Home</div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="{{route('dashboard')}}" class="">
                        <div class="icon"><i class="icon-grid"></i></div>
                        <div class="text">Dashboard</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="center-item">
            <ul class="menu-list">
                <li class="menu-item has-children">
                    <a href="javascript:void(0);" class="menu-item-button">
                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                        <div class="text">Products</div>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="{{route('products.create')}}" class="">
                                <div class="text">Add Product</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="{{route('products.index')}}" class="">
                                <div class="text">Products</div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item has-children">
                    <a href="javascript:void(0);" class="menu-item-button">
                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                        <div class="text">Categories</div>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="{{route('categories.create')}}" class="">
                                <div class="text">Add Category</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="{{route('categories.index')}}" class="">
                                <div class="text">Categories</div>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="menu-item has-children">
                    <a href="javascript:void(0);" class="menu-item-button">
                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                        <div class="text">Brands</div>
                    </a>
                    <ul class="sub-menu">
                        <li class="sub-menu-item">
                            <a href="{{route('brands.create')}}" class="">
                                <div class="text">Add Brand</div>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a href="{{route('brands.index')}}" class="">
                                <div class="text">Brands</div>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="menu-item">
                    <a href="{{route('users.index')}}" class="">
                        <div class="icon"><i class="icon-user"></i></div>
                        <div class="text">User</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="settings.html" class="">
                        <div class="icon"><i class="icon-settings"></i></div>
                        <div class="text">Settings</div>
                    </a>
                </li>

                <li class="menu-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="javascript:void(0);" onclick="this.closest('form').submit();" class="">
                            <div class="icon"><i class="icon-log-out"></i></div>
                            <div class="text">Logout</div>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
