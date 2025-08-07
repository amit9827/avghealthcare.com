@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('auth_header', __('Register a new membership'))

@section('auth_body')
    <form action="{{ route('register') }}" method="POST">
        @csrf

        {{-- Name --}}
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Full name" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user"></span>
                </div>
            </div>
        </div>
        @error('name')
            <span class="text-danger text-sm">{{ $message }}</span>
        @enderror

        {{-- Email --}}
        <div class="input-group mb-3 mt-3">
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        @error('email')
            <span class="text-danger text-sm">{{ $message }}</span>
        @enderror

        {{-- Password --}}
        <div class="input-group mb-3 mt-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        @error('password')
            <span class="text-danger text-sm">{{ $message }}</span>
        @enderror

        {{-- Confirm Password --}}
        <div class="input-group mb-3 mt-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
@endsection

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">
            {{ __('I already have a membership') }}
        </a>
    </p>
@endsection
