@extends('layouts.login')

@section('title', 'Login')

@section('content')
<!-- ======= main ======= -->
<section class="my-login-page">
    <div class="container form-Bg">
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <div class="card-wrapper">
                    <div class="login-logo">
                        <a href="#"><b>Sistem Pendukung Keputusan Pemberian Beasiswa</b></a>
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <form action="{{ route('login.index') }}" method="POST" class="my-login-validation" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username or Email</label>
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required autofocus
                                        placeholder="Input username or email" />
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required data-eye placeholder="Input password" />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input" />
                                    <label for="remember" class="form-check-label">Remember Me</label>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                            </form>
                            <div class="social-auth-links text-center mt-3 mb-3">
                                <p>- OR -</p>
                                <a href="#" class="btn btn-block btn-primary">
                                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                                </a>
                                <a href="#" class="btn btn-block btn-danger">
                                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                                </a>
                            </div>
                            <p class="mb-1">
                                <a href="{{ route('password.request') }}">Forgot password?</a>
                            </p>
                            <p class="mb-0">
                                <a href="{{ route('register.index') }}" class="text-center">Register</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
