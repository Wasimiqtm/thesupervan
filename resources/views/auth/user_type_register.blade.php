@extends('layouts.app')

@section('content')

<style>
    .form-register .title{margin-bottom: 10px;}
    .form-register{height: auto;}
</style>
    <section class="flat-account background">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-register">
                        <div class="title">
                            <h3>Register</h3>
                        </div>
                        <!-- <form action="#" method="get" id="form-register" accept-charset="utf-8"> -->
                        <form id="form-register" method="POST" action="{{ url('register') }}" data-toggle="validator">
                            @csrf
                            <div class="form-box form-group">
                                <label for="name-register">Email Address <span class="help-block">*</span> </label>
                                <!-- <input type="text" id="name-register" name="name-register">-->
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <input type="hidden" name="type" value="{{$userType}}">
                                <div class="help-block with-errors"></div>
                                @if($errors->has('email') && !old('loginform'))
                                    <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('email') }}</p>
                                </span>
                                @endif
                            </div><!-- /.form-box -->

                            <div class="form-box form-group">
                                <label for="name-register">Company Name <span class="help-block">*</span> </label>
                                <!-- <input type="text" id="name-register" name="name-register">-->
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required>
                                <div class="help-block with-errors"></div>
                                @if($errors->has('company_name') && !old('loginform'))
                                    <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('company_name') }}</p>
                                </span>
                                @endif
                            </div><!-- /.form-box -->
                            <div class="form-box form-group">
                                <label for="name-register">VAT <span class="help-block">*</span> </label>
                                <!-- <input type="text" id="name-register" name="name-register">-->
                                <input id="vat_number" type="text" class="form-control @error('vat_number') is-invalid @enderror" name="vat_number" value="{{ old('vat_number') }}" required>
                                <div class="help-block with-errors"></div>
                                @if($errors->has('vat_number') && !old('loginform'))
                                    <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('vat_number') }}</p>
                                </span>
                                @endif
                            </div><!-- /.form-box -->
                            <div class="form-box form-group">
                            <label for="name-register">Address <span class="help-block">*</span> </label>
                            <!-- <input type="text" id="name-register" name="name-register">-->
                            <input id="Address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="email">
                            <div class="help-block with-errors"></div>
                            @if($errors->has('address') && !old('loginform'))
                                <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('address') }}</p>
                                </span>
                            @endif
                        </div>
                            <div class="form-box form-group">
                                <label for="contact_number">Contact Number <span class="help-block">*</span> </label>
                                <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required>
                                <div class="help-block with-errors"></div>
                                @if($errors->has('contact_number') && !old('loginform'))
                                    <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('contact_number') }}</p>
                                </span>
                                @endif
                            </div><!-- /.form-box -->
                            <div class="form-box form-group">
                                <label for="password-register">Password <span class="help-block">*</span></label>
                                <!-- <input type="text" id="password-register" name="password-register"> -->
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <div class="help-block with-errors"></div>
                                @if($errors->has('password') && !old('loginform'))
                                    <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('password') }}</p>
                                </span>
                                @endif
                            </div><!-- /.form-box -->
                            <div class="form-box form-group">
                                <span style="text-align: center">{!! captcha_image_html('RegisterCaptcha') !!}</span>
                                <input type="text"id="CaptchaCode" name="CaptchaCode" placeholder=""  class="form-control  @error('CaptchaCode') is-invalid @enderror"  required autocomplete="CaptchaCode">
                                <div class="help-block with-errors"></div>
                                @if($errors->has('CaptchaCode') && !old('loginform'))
                                    <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('CaptchaCode') }}</p>
                                </span>
                                @endif
                            </div>

                            <div class="form-box">
                                <button type="submit" class="register">Register</button>
                            </div><!-- /.form-box -->
                        </form><!-- /#form-register -->
                    </div><!-- /.form-register -->
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
