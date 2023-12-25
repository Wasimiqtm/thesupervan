@extends('layouts.app')
@section('content')
    <!-- CONTENT + SIDEBAR -->
    <div class="main-wrapper clearfix">
        <div class="site-pagetitle jumbotron">
            <div class="container  theme-container text-center">
                <h3>Goshop My Account</h3>

                <!-- Breadcrumbs -->
                <div class="breadcrumbs">
                    <div class="breadcrumbs text-center">
                        <i class="fa fa-home"></i>
                        <span><a href="index.html">Home</a></span>
                        <i class="fa fa-arrow-circle-right"></i>
                        <span class="current"> Account Information </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="theme-container container">
            <div class="gst-spc3 row">

                <main class="col-md-9 col-sm-8 blog-wrap">
                    <article class="" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
                        <div class="account-details-wrap">
                            <div class="heading-2">
                                <h3 class="title-3 fsz-18">Change Your Personal Details</h3>
                            </div>

                            <div class="account-box">
                                <form  id="myForm" class="form-delivery">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="first-name" name="first_name" class="form-control" placeholder="First Name" value="{{$userData->first_name}}" required>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="last-name" name="last_name" class="form-control" placeholder="Last Name" value="{{$userData->last_name}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" id="email-address" name="email_address" placeholder="Email" class="form-control" value="{{$userData->email}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input id="phone" type="text" id="phone" name="phone" class="form-control" value="{{$userData->phone}}"required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12">
                                            <button class="alt fancy-button" type="submit">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </article>
                </main>


                <aside class="col-md-3 col-sm-4">
                    <div class="main-sidebar" >
<!--                        <div id="search-2" class="widget sidebar-widget widget_search clearfix">
                            <form method="get" id="searchform" class="form-search" action="http://localhost/goshopwp">
                                <input class="form-control search-query" type="text" placeholder="Type Keyword" name="s" id="s" />
                                <button class="btn btn-default search-button" type="submit" name="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>-->
                        <div class="widget sidebar-widget widget_categories clearfix">
                            <h6 class="widget-title">My Account</h6>
                            <ul>
                                <li><a  class="accout-item active" href="{{url('profile')}}" >Profile</a></li>
                                <li><a  class="accout-item " href="{{url('my-orders')}}">My Orders </a></li>
                                <li><a class="accout-item " href="{{url('my-wishlist')}}">Wishlist</a></li>
                                <li><a class="accout-item " href="{{url('/cart-data')}}" >My Cart</a></li>
                            </ul>
                        </div>
                    </div>
                </aside>

            </div>
        </div>

        <div class="clear"></div>
    </div>
    <!-- / CONTENT + SIDEBAR -->

    <!-- Subscribe News -->
    <section class="gst-row gst-color-white row-newsletter ovh">
        <div class="gst-wrapper">
            <div class="gst-column col-lg-12 no-padding text-center">
                <div class="fancy-heading text-center">
                    <h3 class="wht-clr">Subscribe Newsletter</h3>
                    <h5 class="funky-font-2 wht-clr">Sign up for <span class="thm-clr">Special Promotion</span></h5>
                </div>

                <p><strong>Lorem ipsum dolor sit amet</strong>, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut<br /> laoreet dolore magna aliquam erat volutpat.</p>

                <div class="gst-empty-space clearfix"></div>

                <form>
                    <div class="col-md-2"> <h4> <strong class="fsz-20"> <span class="thm-clr">Subscribe</span> to us </strong> </h4> </div>
                    <div class="gst-empty-space visible-sm clearfix"></div>
                    <div class="col-md-4 col-sm-4">
                        <input type="text" class="dblock" placeholder="Enter your name" />
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <input type="text" class="dblock" placeholder="Enter your email address" />
                    </div>

                    <div class="col-md-2 col-sm-4">
                        <input type="submit" class="dblock fancy-button" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- / Subscribe News -->

@endsection


@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            // save user data
            $('#myForm').validator().on('submit', function (e) {
                if (e.isDefaultPrevented()) {
                    return false;
                } else {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    // everything looks good!
                    var formData = $('#myForm').serialize();
                    show_loader();
                    $.ajax({
                        url: '{{ url('update-profile') }}',
                        method: "post",
                        data: {formData: formData},
                        success: function (response) {
                            if(response){
                                if(response.status){
                                    toastr.success(response.message);
                                    hide_loader();
                                }
                            }
                        }
                    });
                }
            })
        });
    </script>
@endsection
