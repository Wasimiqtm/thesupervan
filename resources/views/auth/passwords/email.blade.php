@extends('layouts.app')

@section('content')
<section class="flat-breadcrumb">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumbs">
                            <li class="trail-item">
                                <a href="#" title="">Home</a>
                                <span><img src="{{asset('front_assets/images/icons/arrow-right.png')}}" alt=""></span>
                            </li>
                            <li class="trail-item">
                                <a href="#" title="">Shop</a>
                                <span><img src="{{asset('front_assets/images/icons/arrow-right.png')}}" alt=""></span>
                            </li>
                            <li class="trail-end">
                                <a href="#" title="">Smartphones</a>
                            </li>
                        </ul><!-- /.breacrumbs -->
                    </div><!-- /.col-md-12 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.flat-breadcrumb -->

        <section class="flat-account background">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-login form-reset">
                            <div class="title reset-password">
                                <h3>Reset Password</h3>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ url('password/email') }}" data-toggle="validator">
                                @csrf
                                <div class="form-box form-group">
                                    <label for="name-login">Email address * </label>
                                    <!-- <input type="text" id="name-login" name="name-login" placeholder="Ali"> -->
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <div class="help-block with-errors"></div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <p class="help-block">{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div><!-- /.form-box -->
                                
                                
                                <div class="form-box">
                                    <button type="submit" class="login">Send Password Reset Link</button>
                                </div><!-- /.form-box -->
                            </form><!-- /#form-login -->
                        </div><!-- /.form-login -->
                    </div><!-- /.col-md-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.flat-account -->

        <section class="flat-row flat-iconbox style1 background">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="iconbox style1 v1">
                            <div class="box-header">
                                <div class="image">
                                    <img src="{{asset('front_assets/images/icons/car.png')}}" alt="">
                                </div>
                                <div class="box-title">
                                    <h3>Worldwide Shipping</h3>
                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.box-header -->
                        </div><!-- /.iconbox -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="iconbox style1 v1">
                            <div class="box-header">
                                <div class="image">
                                    <img src="{{asset('front_assets/images/icons/order.png')}}" alt="">
                                </div>
                                <div class="box-title">
                                    <h3>Order Online Service</h3>
                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.box-header -->
                        </div><!-- /.iconbox -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="iconbox style1 v1">
                            <div class="box-header">
                                <div class="image">
                                    <img src="{{asset('front_assets/images/icons/payment.png')}}" alt="">
                                </div>
                                <div class="box-title">
                                    <h3>Payment</h3>
                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.box-header -->
                        </div><!-- /.iconbox -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="iconbox style1 v1">
                            <div class="box-header">
                                <div class="image">
                                    <img src="{{asset('front_assets/images/icons/return.png')}}" alt="">
                                </div>
                                <div class="box-title">
                                    <h3>Return 30 Days</h3>
                                </div>
                                <div class="clearfix"></div>
                            </div><!-- /.box-header -->
                        </div><!-- /.iconbox -->
                    </div><!-- /.col-md-6 col-lg-3 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.flat-iconbox -->
@endsection
