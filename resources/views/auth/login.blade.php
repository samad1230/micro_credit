@extends('Home_layout.home_master_layout')
@section('content')

    @guest
        <div class="auth-layout-wrap" style="background-image: url({{asset('Media/asset/banar.jpg')}})">
            <div class="auth-content">
                <div class="card o-hidden">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="p-4">
                                <div class="auth-logo text-center mb-4"><img src="{{asset('Media/asset/logo.png')}}" alt=""></div>
                                <h1 class="mb-3 text-18">Sign In</h1>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input id="email" type="email" class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input id="password" type="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-rounded btn-primary btn-block mt-2">
                                        {{ __('Login') }}
                                    </button>
                                </form>
                                @if (Route::has('password.request'))
                                    <div class="mt-3 text-center"><a class="text-muted" href="#">
                                            <u>Forgot Password?</u></a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 text-center" style="background-size: cover;background-image: url({{asset('Admin_asset/dist-assets/images/photo-long-3.jpg')}})">
                            <div class="pr-3 auth-right"><a class="btn btn-rounded btn-outline-primary btn-outline-email btn-block btn-icon-text" href="{{url('register')}}"> Sign up</a><a class="btn btn-rounded btn-outline-primary btn-outline-email btn-block btn-icon-text" href="#"><i class="i-Mail-with-At-Sign"></i> Sign up with Email</a><a class="btn btn-rounded btn-outline-google btn-block btn-icon-text"><i class="i-Google-Plus"></i> Sign up with Google</a><a class="btn btn-rounded btn-block btn-icon-text btn-outline-facebook"><i class="i-Facebook-2"></i> Sign up with Facebook</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else

        @include('Dashboard.Admin_dashboard')

    @endguest



@endsection
