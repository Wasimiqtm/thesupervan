@extends('layouts.app')

@section('content')
    <div class="main-wrapper clearfix">
        <div class="site-pagetitle jumbotron">
            <div class="container  theme-container text-center">
                <h3>Goshop Contact</h3>

                <!-- Breadcrumbs -->
                <div class="breadcrumbs">
                    <div class="breadcrumbs text-center">
                        <i class="fa fa-home"></i>
                        <span><a href="index.html">Home</a></span>
                        <i class="fa fa-arrow-circle-right"></i>
                        <span class="current">Login / Register</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Us Start -->
        <section class="gst-row"  id="contact-us">
           <div class="row">
               <div class="col-md-6">

                   <div class="cntct-frm  clearfix">
                       <h3>Login</h3>
                       <form id="form-login" method="POST" action="{{ url('login') }}" data-toggle="validator">
                           @csrf

                           <div class="form-group col-sm-12 form-alert"></div>
                           <div class="contact-form">
                               <div class="form-group col-sm-12">

                                   <input id="email" type="email" class="form-control name input-your-name @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                                   <div class="help-block with-errors"></div>
                                   @if($errors->has('email') && old('loginform'))
                                       <span class="invalid-feedback" role="alert">
                                <p class="help-block">{{ $errors->first('email') }}</p>
                                </span>
                                   @endif
                               </div>
                               <div class="form-group col-sm-12">
                                   <input id="password" type="password" class=form-control email input-email @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="password">
                                   <div class="help-block with-errors"></div>
                                   @if($errors->has('password') && old('loginform'))
                                       <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('password') }}</p>
                                </span>
                                       @enderror

                               </div>
                               <div class="form-group col-sm-12">
                                   <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                   <label for="remember">Remember me</label>
                               </div>
                           </div>
                           <div class="form-group col-sm-12 text-center">
                               <button type="submit" class="login alt fancy-button">Login</button>
                               <!-- <a href="#" title="">Lost your password?</a> -->
                               @if (Route::has('password.request'))
                                   <a class="btn btn-link" href="{{ route('forget.password.get') }}">
                                       {{ __('Forgot Your Password?') }}
                                   </a>
                               @endif

                           </div>
                       </form>
                   </div>
               </div>

               <div class="col-md-6">
                   <div class="form-register" style="height:629px !important">
                       <div class="title">
                           <h3>Register</h3>
                       </div>
                       <!-- <form action="#" method="get" id="form-register" accept-charset="utf-8"> -->
                       <form id="form-register" method="POST" action="{{ url('register') }}" data-toggle="validator">
                           @csrf

                           <div class="form-box form-group">
                               <label for="name-register">Name<span class="help-block">*</span> </label>
                               <!-- <input type="text" id="name-register" name="name-register">-->
                               <input id="name" type="text" class="form-control" name="email" value="{{ old('name') }}" required autocomplete="name">
                               <div class="help-block with-errors"></div>
                               @if($errors->has('name') && !old('loginform'))
                                   <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('name') }}</p>
                                </span>
                               @endif
                           </div>
                           <div class="form-box form-group">
                               <label for="name-register">Email Address <span class="help-block">*</span> </label>
                               <!-- <input type="text" id="name-register" name="name-register">-->
                               <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                               <div class="help-block with-errors"></div>
                               @if($errors->has('email') && !old('loginform'))
                                   <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('email') }}</p>
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
                           </div>
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
                               <label for="name-register">Type <span class="help-block">*</span> </label>
                               <select name="type" id="type" required>
                                   <option value="">Select Account Type</option>
                                   <option value="retailer">retailer</option>
                                   <option value="wholesaler">wholesaler</option>
                               </select>
                               <div class="help-block with-errors"></div>
                               @if($errors->has('address') && !old('loginform'))
                                   <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('address') }}</p>
                                </span>
                               @endif
                           </div>
                           {!! captcha_image_html('RegisterCaptcha') !!}
                           <input type="text"id="CaptchaCode" name="CaptchaCode" placeholder=""  class="form-control  @error('CaptchaCode') is-invalid @enderror"  required autocomplete="CaptchaCode">
                           <div class="help-block with-errors"></div>
                           @if($errors->has('CaptchaCode') && !old('loginform'))
                               <span class="invalid-feedback" role="alert">
                                    <p class="help-block">{{ $errors->first('CaptchaCode') }}</p>
                                </span>
                           @endif
                           <div class="form-box">
                               <button type="submit" class="register">Register</button>
                           </div><!-- /.form-box -->
                       </form><!-- /#form-register -->
                   </div><!-- /.form-register -->
               </div>
           </div>
        </section>
        <!-- / Contact Us Ends -->

        <!-- Map Starts-->
        <section id="map-canvas2"></section>
        <!-- / Map Ends -->


        <div class="clear"></div>
    </div>

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


@endsection
