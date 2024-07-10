@extends('layouts.login')

@section('title', 'Register')

@section('content')
<section class="my-login-page">
    <div class="container form-Bg">

        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <div class="card-wrapper">
                    <div class="register-logo">
                        <a href="#"><b>Sistem Pendukung Keputusan Pemberian Beasiswa</b></a>
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <form action="{{ route('register') }}" method="POST" class="my-register-validation"
                                novalidate="">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autofocus placeholder="Input full name" />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required placeholder="Input email" />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required placeholder="Input username" />
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required placeholder="Input password" />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input id="password_confirmation" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" required placeholder="Confirm password" />
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                                </div>
                            </form>
                            <p class="mt-3 text-center">
                                <a href="{{ route('login.index') }}">Already have an account? Sign In</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection