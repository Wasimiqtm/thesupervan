<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"><!--<![endif]-->
    <head>
        <!-- Basic Page Needs -->
        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->


        <title>@yield('title')</title>
        <meta name="google-site-verification" content="KfzyleiRDQ_CWIXC6T7dNfUqcbUxdX2DbHz657-VAOo" />
        <meta name="description" content="@yield('description')">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="CreativeLayers">
        <!-- Mobile Specific Metas -->

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('front_assets/ico/apple-touch-icon-144-precomposed.html')}}">
        <link rel="shortcut icon" href="{{asset('front_assets/ico/favicon.html')}}">

        <!-- CSS Global -->
        <link href="{{asset('front_assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('front_assets/plugins/bootstrap-select-1.9.3/dist/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('front_assets/plugins/owl-carousel2/assets/owl.carousel.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('front_assets/plugins/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('front_assets/plugins/royalslider/skins/universal/rs-universal.css')}}" rel="stylesheet">
        <link href="{{asset('front_assets/plugins/royalslider/royalslider.css')}}" rel="stylesheet">
        <link href="{{asset('front_assets/plugins/subscribe-better-master/subscribe-better.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/jquery-ui-1.10.1.custom.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Icons Font CSS -->
        <link href="{{asset('front_assets/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Theme CSS -->
        <link href="{{asset('front_assets/css/style.css?v=1.1.1')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('front_assets/css/header.css?v=1.1.1')}}" rel="stylesheet" type="text/css">


        <script>
        var base_url = '{{ url("") }}';
        var admin_url = '{{ url("admin") }}';
    </script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5dfb9b29f3c77900129a7017&product=sticky-share-buttons&cms=sop' async='async'></script>
    </head>
    <body class="woocommerce-cart {{@$class}}">
       @include('sections.header')
       <div class="main-wrapper clearfix">


           @yield('content')


       </div>

       @include('sections.footer')
        <!-- Javascript -->
        <!-- <script
        src="https://www.paypal.com/sdk/js?client-id=AcVSOYnBQbk_DCYhIzXQ_KrcqxVMeOuZDED5JQdEItaBvHTNcDxRzJYdiJCIlp1XzVc0r1UKs3DBXHXe">
        </script> -->
        <script src="{{asset('front_assets/plugins/jquery/jquery-2.1.3.js')}}"></script>
        <script src="{{asset('front_assets/plugins/royalslider/jquery.royalslider.min.js')}}"></script>
        <script src="{{asset('front_assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('front_assets/plugins/bootstrap-select-1.9.3/dist/js/bootstrap-select.min.js')}}"></script>
        <script src="{{asset('front_assets/plugins/owl-carousel2/owl.carousel.min.js')}}"></script>
        <script src="{{asset('front_assets/plugins/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.concat.min.js')}}"></script>
        <script src="{{asset('front_assets/plugins/isotope-master/dist/isotope.pkgd.min.js')}}"></script>
        <script src="{{asset('front_assets/plugins/subscribe-better-master/jquery.subscribe-better.min.js')}}"></script>

        <!-- Page JS -->
        <script src="{{asset('front_assets/js/countdown.js')}}"></script>
        <script src="{{asset('front_assets/js/jquery.sticky.js')}}"></script>
        <script src="{{asset('front_assets/js/custom.js?v=1.1.1')}}"></script>
       <script src="{{ asset('js/jquery-ui-1.10.1.custom.min.js') }}"></script>
       <script src="{{ asset('js/validator.min.js') }}"></script>

        <script>
            $(document).ready(function () {
                getCartHistory();
                $("a[title ~= 'BotDetect']").css('visibility', 'hidden');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            })

        </script>

        @include('admin.sections.notification')

        @yield('scripts')

       <script type="text/javascript" src="{{url('front_assets/js/scripts.js?v=1.1.1')}}"></script>

       <script type="text/javascript" src="{{url('js/loadingoverlay.min.js')}}"></script>
    </body>
</html>
