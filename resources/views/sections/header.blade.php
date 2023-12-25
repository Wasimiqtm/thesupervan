<!-- HEADER -->
<header id="masthead" class="clearfix" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
    <div class="site-subheader site-header">
        <div class="container theme-container">
            <!-- Language & Currency Switcher -->
            <ul class="pull-left list-unstyled list-inline">
<!--                <li class="nav-dropdown language-switcher">
                    <div>EN</div>
                    <ul class="nav-dropdown-inner list-unstyled list-lang">
                        <li><span class="current">EN</span></li>
                        <li><a title="Russian" href="#">RU</a></li>
                        <li><a title="France" href="#">FR</a></li>
                        <li><a title="Brazil" href="#">IT</a></li>
                    </ul>
                </li>
                <li class="nav-dropdown language-switcher">
                    <div><span class="fa fa-dollar"></span>USD</div>
                    <ul class="nav-dropdown-inner list-unstyled list-currency">
                        <li><span class="current"><span class="fa fa-dollar"></span>USD</span></li>
                        <li><a title="Euro" href="#"><span class="fa fa-eur"></span>Euro</a></li>
                        <li><a title="GBP" href="#"><span class="fa fa-gbp"></span>GBP</a></li>
                    </ul>
                </li>-->
            </ul>

            <!-- Mini Cart -->
            <ul class="pull-right list-unstyled list-inline">

                @if(Auth::check())
                    <li  class="menu-item">
                        <a href="{{url('profile')}}" title="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">{{ Auth::user()->first_name ?? '' }} {{Auth::user()->last_name??'' }} &nbsp;<?php echo (Auth::user()->type =='wholesaler' || Auth::user()->type =='retailer')?(
                                '(<span  style="font-weight: bold;color: green">'.Auth::user()->type.'</span>)'):''?></a>
                    </li>
                @endif
                @if(Auth::check())
                    <li class="nav-dropdown">
                        <a href="#">My Account</a>
                        <ul class="nav-dropdown-inner list-unstyled accnt-list">
                            <li><a  href="{{url('profile')}}" >Profile</a></li>
                            <li><a href="{{url('my-orders')}}">My Orders </a></li>
                            <li><a href="{{url('my-wishlist')}}">Wishlist</a></li>
                            <li><a  href="{{url('/cart-data')}}" >My Cart</a></li>

                            @if(Auth::check())
                                <li>

                                    <a href="{{ url('logout') }}"
                                       onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endif


                        </ul>
                    </li>
                @endif
                    <li id="cartContent" class="cartContent">

                    </li>
                <li class="menu-item">
                    <a  href="{{url('make-payment')}}">Checkout</a>
                </li>

                @if(Auth::check())
                    <li class="menu-item">

                        <a href="{{ url('logout') }}"
                           onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="menu-item">
                        <a href="{{ url('login') }}" data-toggle="modal">Login</a>
                    </li>
                @endif
                    @if(Auth::check())
                        @if(Auth::user()->type =='wholesaler' || Auth::user()->type =='dropshipper')
                            <?php $totalAmountWallet = getWholsellerDataWallet(Auth::user()->id);?>
                <li>
                    <a href="javascript:void(0)" data-toggle="modal">Wallet Amount :- &#163;{{number_format($totalAmountWallet,'2','.','')}}</a>
                </li>
                        @endif
                    @endif
            </ul>

        </div>
    </div>
    <div class="header-wrap" id="typo-sticky-header">
        <div class="container theme-container reltv-div">

            <div class="pull-right header-search visible-xs">

                <a id="open-popup-menu" class="nav-trigger header-link-search" href="javascript:void(0)" title="Menu">
                    <i class="fa fa-bars"></i>
                </a>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="top-header pull-left">
                        <div class="logo-area">
                            <a href="{{url('/')}}" class="thm-logo fsz-35">
                                <!--<img src="files/main-logo.png" alt="Goshop HTML Theme">-->
                                <b class="bold-font-3 wht-clr"> GoShop </b> <span
                                    class="thm-clr funky-font"> bikes </span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Navigation -->

                <div class="col-md-9 col-sm-9 static-div">
                    <div class="navigation pull-left">
                        <nav>
                            <div class="" id="primary-navigation">
                                <ul class="nav navbar-nav primary-navbar">
                                    <li class="dropdown active"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="dropdown mega-dropdown">
                                        <a href="{{url('products')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" >Products
                                        <div class="dropdown-menu mega-dropdown-menu pr"  style="background: white no-repeat url({{asset('front_assets/img/extra/megamenu-1.jpg')}}) right top; ">
                                            @foreach(getAllCategoryForList() as $category)
                                            <div class="col-md-3 col-sm-3 menu-block">
                                                <div class="sub-list">

                                                        <a   href="{{url('products?category='.$category->id.'-'.string_replace($category->name))}}"  > <h2 class="blk-clr title"> <b class="extbold-font-4 fsz-16">{{ $category->name }} </b>    </h2> </a>
                                                    <img src="{{asset('uploads/categories/'.$category->image)}}" alt="" width="30" height="30">

                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        </a>
                                    </li>
                                    <li><a href="#">Repair Services</a></li>
                                    <li><a href="contact-us.html">About Us</a></li>
                                    <li><a href="contact-us.html">Contact Us</a></li>
                                </ul>
                            </div>

                        </nav>
                    </div>
<!--                    <div class="pull-right srch-box">

                        <a id="open-popup-search" class="header-link-search" href="javascript:void(0)" title="Search">
                            <i class="fa fa-search"></i>
                        </a>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</header>

<!-- / HEADER -->
