@extends('layouts.app')
@section('content')

    <div id="owl-carousel-main" class="owl-carousel nav-1">
        <div class="gst-slide">
            <img src="{{asset('front_assets/img/slides/3.jpg')}}" alt=""/>
            <div class="gst-caption container theme-container">
                <div>
                    <div class="caption-right">
                        <h3 class="fsz-40 wht-clr funky-font-2">  Waterproof Jacket  </h3>
                        <h2>Goshop <span class="thm-clr">Big Sale</span></h2>
                        <p class="lgt-gry">Cycling is a healthy, fun and exciting way to travel. No matter what type of cycling you're into, we've got a bike for you.</p>
                        <a class="fancy-btn-alt" href="#">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="gst-slide">
            <img src="{{asset('front_assets/img/slides/1.jpg')}}"  alt=""/>
            <div class="gst-caption container theme-container">
                <div>
                    <div class="caption-center">

                        <p class="slider-title"> <span class="fsz-220 funky-font">Bikes</span> <span class="funky-font-2 fsz-28">Slim, Strong, and Fun Anytime</span> </p>
                        <a class="fancy-btn" href="#">Find Your Bike</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="gst-slide">
            <img src="{{asset('front_assets/img/slides/2.jpg')}}" alt=""/>
            <div class="gst-caption container theme-container">
                <div>
                    <div class="caption-center">

                        <p class="slider-title"> <span class="fsz-220 funky-font">Riding</span> <span class="funky-font-2 fsz-35">our bikes stronger <br> than you ever imagined </span> </p>
                        <a class="fancy-btn" href="#">Find Your Bike</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="service-sec">
        <div class="container theme-container">
            <div class="service">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="left">
                            <div class="icon"><img src="{{asset('front_assets/img/extra/icon-delivery.png')}}" alt="Delivery"></div>
                        </div>

                        <p class="title-3 fsz-18">Fast delivery</p>
                        <p class="second-heading">Did you know that we ship to over 24 different countries.</p>
                    </div>

                    <div class="col-sm-4">
                        <div class="left">
                            <div class="icon"><img src="{{asset('front_assets/img/extra/icon-money-back.png')}}" alt="Money back"></div>
                        </div>

                        <p class="title-3 fsz-18">100% money back</p>
                        <p class="second-heading">Did you know that we ship to over 24 different countries.</p>
                    </div>

                    <div class="col-sm-4">
                        <div class="left">
                            <div class="icon"><img src="{{asset('front_assets/img/extra/icon-support.png')}}" alt="Support"></div>
                        </div>

                        <p class="title-3 fsz-18">Awesome support</p>
                        <p class="second-heading">Did you know that we ship to over 24 different countries.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gst-spc1 row-arrivals woocommerce ovh light-bg">
        <div class="container theme-container">
            <div class="gst-column col-lg-12 no-padding text-center">
                <div class="fancy-heading text-center">
                    <h3><span class="thm-clr">New</span> Arrivals</h3>
                    <h5 class="funky-font-2">Trending Fashion</h5>
                </div>

                <!-- Filter for items -->
                <div class="clearfix tabs space-15">
                    <ul class="filtrable products_filter">
                        <li class="active"><a href="#" data-filter=".cat-1">CLOTHING</a></li>
                        <li class=""><a href="#" data-filter=".cat-2" >Woman</a></li>
                        <li class=""><a href="#" data-filter=".cat-3">Men</a></li>
                        <li class=""><a href="#" data-filter=".cat-4" >Kid's</a></li>
                        <li class=""><a href="#" data-filter=".cat-5">Accessories</a></li>
                        <li class=""><a href="#" data-filter=".cat-6">Shoes</a></li>
                    </ul>
                </div>

                <!-- Portfolio items -->
                <div class="row isotope isotope-items cat-filter hvr2">
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item cat-1 cat-2 cat-5">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-1.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> CICLYSMO JACKET </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item cat-1 cat-4 cat-6">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-2.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> LYCRA BITZ MEN CLOTHING </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item cat-1 cat-2">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-3.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star half"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> CICLYSMO JACKET </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item cat-1 cat-4 cat-6">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-4.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> LYCRA BITZ MEN CLOTHING </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item cat-3 cat-5">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-5.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> CICLYSMO JACKET </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item  cat-2 cat-4 cat-6">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-6.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> LYCRA BITZ MEN CLOTHING </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item cat-3 cat-5">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-7.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> CICLYSMO JACKET </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item  cat-2 cat-4 cat-6">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-8.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> LYCRA BITZ MEN CLOTHING </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item cat-3 cat-5">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-9.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> CICLYSMO JACKET </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 isotope-item cat-3 ">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{asset('front_assets/img/products/cat-10.jpg')}}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="#" class="fancy-btn-alt fancy-btn-small">View All Jeans</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="#"> LYCRA BITZ MEN CLOTHING </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> $299.00 </span> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="gst-compare dscnt-bnnr">

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 dscnt-3">
            <div class="col-lg-7 no-padding right">
                <h5 class="title-1 fsz-35">Popular Products</h5>

                <h3 class="sec-title fsz-45">
                    <span class="thm-clr"> WINTER </span>  JACKET
                </h3>
                <p class="fsz-16 blklt-clr no-mrgn">PRE SEASON EVENT AT OUR <b class="fw900">NEW ARRIVAL</b></p>
                <p> <i>*Discount applied automatically at checkout</i> </p>
                <a class="smpl-btn view-all" href="#"> SHOP ALL  JACKET NOW </a>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 dscnt-4">
            <div class="col-lg-8 no-padding wht-clr">
                <h5 class="title-1 fsz-35"> Trending Fashion </h5>
                <h2 class="sec-title fsz-45"> END OF <span class="clr1"> SEASON </span> </h2>
                <p class="fsz-16 no-mrgn">PRE SEASON EVENT AT OUR <b class="fw900">NEW ARRIVAL</b></p>
                <p> <i>*Discount applied automatically at checkout</i> </p>
                <a class="smpl-btn view-all" href="#"> SHOP ALL  JACKET NOW </a>
            </div>
        </div>

        <div class="descount bold-font-2"> <div class="rel-div"> <p> DISCOUNT UP TO 75% </p> </div> </div>
    </section>

    <section class="gst-spc1 row-arrivals woocommerce ovh">
        <div class="container theme-container">
            <div class="gst-column col-lg-12 no-padding text-center">
                <div class="fancy-heading text-center">
                    <h3><span class="thm-clr">Top</span> Collections</h3>
                    <h5 class="funky-font-2">Choose Your Collections</h5>
                </div>

                <!-- Filter for items -->
                <div class="clearfix tabs space-15">
                    <ul class="coll-filtrable products_filter">
                        <li class="active"><a href="#" class="get_collection" data-param = 'all'>All Product</a></li>
                        <li class=""><a href="#" class="get_collection" data-param = 'new'>New Arrival </a></li>
                        <li class=""><a href="#" class="get_collection" data-param = 'featured'>Featured</a></li>
                        <li class=""><a href="#" class="get_collection" data-param = 'hot'>Hot Sale</a></li>
                    </ul>
                </div>

                <!-- Portfolio items -->
                <div id="top_collection_products"></div>
            </div>
        </div>
    </section>

    <section class="clear">
        <div class="prod-offers">
            <div class="container theme-container">
                <div class="col-md-6 col-sm-8 offers-img">
                    <img src="{{asset('front_assets/img/banner/offer.png')}}" alt="">
                </div>
                <div class="col-md-6 col-sm-8 middle-box">
                    <div class="offers-cntnt cnt-tbl">
                        <div class="middle">
                            <h2 class="funky-font-2 fsz-25 no-mrgn"> Summer Hot Products </h2>
                            <h2 class="title-2 fsz-50 no-mrgn"> <span class="thm-clr">FREE</span> YOUR RUN </h2>
                            <p class="title-3 fsz-15"> ULTIMATE FLEXIBILITY FOR MORE NATURAL RIDE </p>
                            <p class="spc-15">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibhumils euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex etlisun commodo consequat. </p>
                            <p class="spc-15"></p>
                            <a class="fancy-btn-black fancy-btn-small" href="#">Learn More</a> <a class="fancy-btn fancy-btn-small" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="spc-wrp row-arrivals woocommerce clear">
<!--        <div class="container theme-container">
            <div class="gst-column col-lg-12 no-padding text-center">
                <div class="fancy-heading text-center spcbtm-15">
                    <h3><span class="thm-clr">Most</span> Viewed</h3>
                    <h5 class="funky-font-2"> Special price only this month </h5>
                </div>

                &lt;!&ndash; Portfolio items &ndash;&gt;
                <div class="row hvr2 spc-ofr">
                    @foreach($mostViewdProducts as $most)
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="portfolio-wrapper">
                            <div class="portfolio-thumb">
                                <img src="{{ $most->default_image_url }}" alt="">
                                <div class="portfolio-content">
                                    <div class="rating">
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star active"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <div class="pop-up-icon">
                                        <a  data-toggle="modal" href="#product-preview" class="center-link"><i class="fa fa-search"></i></a>
                                        <a href="#" class="left-link"><i class="fa fa-heart"></i></a>
                                        <a class="right-link" href="#"><i class="cart-icn"> </i></a>
                                    </div>
                                    <div class="all-view">
                                        <a href="{{ route('get.product.detail',['id' =>($most->slug!='')?$most->slug:Hashids::encode(($most->id))]) }}" class="fancy-btn-alt fancy-btn-small">View  Product</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3> <a class="title-3 fsz-16" href="{{ route('get.product.detail',['id' =>($most->slug!='')?$most->slug:Hashids::encode(($most->id))]) }}"> {{ $most->name }} </a> </h3>
                                <p class="font-3">Price: <span class="thm-clr"> {{ '$'.$most->price }} </span> </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>-->
    </section>


    <section class="gst-row row-latest-news ovh">
        <div class="container theme-container">
            <div class="gst-column col-lg-12 no-padding">
                <div class="fancy-heading text-center">
                    <h3>Latest <span class="thm-clr">News</span></h3>
                    <h5 class="funky-font-2">News from our blog</h5>
                </div>

                <div class="row gst-post-list">
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <a href="single.html">
                            <img src="{{asset('front_assets/img/blog/blog-1.jpg')}}" alt="" />
                        </a>
                        <div class="media clearfix">
                            <div class="entry-meta media-left">
                                <div class="entry-time meta-date">
                                    <time datetime="2015-12-09T21:10:20+00:00">
                                        <span class="entry-time-date dblock">26</span>
                                        Dec
                                    </time>
                                </div>
                                <div class="entry-reply">
                                    <a href="single.html#comments" class="comments-link">
                                        <i class="fa fa-comment dblock"></i>
                                        125
                                    </a>
                                </div>
                            </div>
                            <div class="media-body">
                                <header class="entry-header">
                                            <span class="vcard author entry-author">
                                                <a class="url fn n" rel="author" href="single.html">
                                                    Scott Williams
                                                </a>
                                            </span>
                                    <span class="entry-categories">
                                                <a href="category.html">Bike Tours</a>
                                            </span>
                                    <h3 class="entry-title">
                                        <a class="blk-clr" href="single.html" rel="bookmark">Bike injuries are on the rise, but there's still reason to ride</a>
                                    </h3>

                                    <a href="single.html" class="read-more-link thm-clr">Read More <i class="fa fa-long-arrow-right"></i> </a>
                                </header>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <a href="single.html">
                            <img src="{{asset('front_assets/img/blog/blog-2.jpg')}}" alt="" />
                        </a>
                        <div class="media clearfix">
                            <div class="entry-meta media-left">
                                <div class="entry-time meta-date">
                                    <time datetime="2015-12-09T21:10:20+00:00">
                                        <span class="entry-time-date dblock">26</span>
                                        Dec
                                    </time>
                                </div>
                                <div class="entry-reply">
                                    <a href="single.html#comments" class="comments-link">
                                        <i class="fa fa-comment dblock"></i>
                                        125
                                    </a>
                                </div>
                            </div>
                            <div class="media-body">
                                <header class="entry-header">
                                            <span class="vcard author entry-author">
                                                <a class="url fn n" rel="author" href="single.html">
                                                    Scott Williams
                                                </a>
                                            </span>
                                    <span class="entry-categories">
                                                <a href="category.html">Bike Tours</a>
                                            </span>
                                    <h3 class="entry-title">
                                        <a class="blk-clr" href="single.html" rel="bookmark">Bike injuries are on the rise, but there's still reason to ride</a>
                                    </h3>

                                    <a href="single.html" class="read-more-link thm-clr">Read More <i class="fa fa-long-arrow-right"></i> </a>

                                </header>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <a href="single.html">
                            <img src="{{asset('front_assets/img/blog/blog-3.jpg')}}" alt="" />
                        </a>
                        <div class="media clearfix">
                            <div class="entry-meta media-left">
                                <div class="entry-time meta-date">
                                    <time datetime="2015-12-09T21:10:20+00:00">
                                        <span class="entry-time-date dblock">26</span>
                                        Dec
                                    </time>
                                </div>
                                <div class="entry-reply">
                                    <a href="single.html#comments" class="comments-link">
                                        <i class="fa fa-comment dblock"></i>
                                        125
                                    </a>
                                </div>
                            </div>
                            <div class="media-body">
                                <header class="entry-header">
                                            <span class="vcard author entry-author">
                                                <a class="url fn n" rel="author" href="single.html">
                                                    Scott Williams
                                                </a>
                                            </span>
                                    <span class="entry-categories">
                                                <a href="category.html">Bike Tours</a>
                                            </span>
                                    <h3 class="entry-title">
                                        <a class="blk-clr" href="single.html" rel="bookmark">Bike injuries are on the rise, but there's still reason to ride</a>
                                    </h3>

                                    <a href="single.html" class="read-more-link thm-clr">Read More <i class="fa fa-long-arrow-right"></i> </a>

                                </header>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gst-row gst-color-white row-they-say2 ovh" id="they-say-carousel">
        <div class="container theme-container">
            <div class="gst-column col-lg-12 no-padding text-center">
                <div class="fancy-heading text-center wht-clr">
                    <h3>They Says</h3>
                    <h5 class="funky-font-2">Happy Clients</h5>
                </div>

                <div class="quotes-carousel">
                    <div class="they-say nav-2">
                        <div class="item">
                            <p><strong>Cycling is a healthy</strong>, fun and exciting way to travel. No matter what type of cycling you're into, we;ve got a bike for you. We stock one of the larget bicycle ranges everywhere.</p>
                            <cite>
                                <strong>JESSICA WILSON</strong> - France
                            </cite>
                        </div>

                        <div class="item">
                            <p><strong>Cycling is a healthy</strong>, fun and exciting way to travel. No matter what type of cycling you're into, we;ve got a bike for you. We stock one of the larget bicycle ranges everywhere.</p>
                            <cite>
                                <strong>JESSICA WILSON</strong> - France
                            </cite>
                        </div>

                        <div class="item">
                            <p><strong>Cycling is a healthy</strong>, fun and exciting way to travel. No matter what type of cycling you're into, we;ve got a bike for you. We stock one of the larget bicycle ranges everywhere.</p>
                            <cite>
                                <strong>JESSICA WILSON</strong> - France
                            </cite>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="container theme-container">
        <div class="brand-wrap2">
            <div class="brand-slider text-center">
                @foreach($brands as $brand)
                    <div class="item"> <a href="#"><img src="{{asset('uploads/brands/'.$brand)}}" alt=""></a> </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        const url = "{{ url('get-home-products') }}";
        const param = 'all';
        getHomeProducts(url, param);

        $(".get_collection").click(function (e) {
            e.preventDefault();
            var param = $(this).attr('data-param');
            show_loader();
            getHomeProducts(url, param);
        });




    });
</script>
@endsection




