@extends('layouts.app')

@section('content')

    <section class="flat-account background">
        <div class="cotainer">
            <div class="row  justify-content-center">
                <div class="col-md-8">
                    <div class="form-login">
                        <div class="title">
                            <h3>Reset Password</h3>
                        </div>
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        <form action="{{ route('forget.password.post') }}" method="POST">
                            @csrf
                            <div class="form-box form-group">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-box">
                                <button type="submit" class="login">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- /.flat-account -->

@endsection
