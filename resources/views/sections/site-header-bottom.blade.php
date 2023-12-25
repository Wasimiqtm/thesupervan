<div class="header-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-2">
                <div id="mega-menu">
                    @include('sections.sidebar')
                </div>
            </div><!-- /.col-md-3 col-2 -->
            <div class="col-md-9 col-10">
                <div class="nav-wrap">
                    <div id="mainnav" class="mainnav">
                        <ul class="menu">
                            <li class="column-1 active">
                                <a href="{{url('/')}}" title="">Home</a>
                            </li><!-- /.column-1 -->
                            <li class="column-1">
                                <a href="{{url('products')}}" title="">Products</a>
                                <!-- <ul class="submenu">
                                    <li>
                                        <a href="{{url('categories')}}" title=""><i class="fa fa-angle-right" aria-hidden="true"></i>Categories</a>
                                    </li>
                                    <li>
                                        <a href="{{url('products')}}" title=""><i class="fa fa-angle-right" aria-hidden="true"></i>Products</a>
                                    </li>
                                </ul> -->
                            </li><!-- /.column-1 -->

                            <li class="column-1">
                                <a href="{{ url('brands') }}">Brands</a>
                            </li><!-- /.has-mega-menu -->

                            <li class="has-mega-menu">
                                <a href="{{ url('page/term-condition') }}">Terms & Conditions</a>
                            </li><!-- /.has-mega-menu -->
                            <li class="column-1">
                                <a href="{{url('faqs')}}" title="">FAQs</a>
                            </li><!-- /.column-1 -->
                            <li class="column-1">
                                <a href="{{url('page/about-us')}}" title="">About</a>
                            </li><!-- /.column-1 -->
                            <li class="column-1">
                                <a href="{{url('page/contact-us')}}" title="">Contact</a>
                            </li><!-- /.column-1 -->
                        </ul><!-- /.menu -->
                    </div><!-- /.mainnav -->
                </div><!-- /.nav-wrap -->
                <!-- <div class="today-deal"> -->
                    <!-- <a href="#" title="">TODAY DEALS</a> -->
                <!-- </div>/.today-deal -->
                <div class="btn-menu">
                    <span></span>
                </div><!-- //mobile menu button -->
            </div><!-- /.col-md-9 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.header-bottom -->
