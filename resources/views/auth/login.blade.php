@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])


@section('auth_header', __('Sign in to start your session'))

@section('auth_body')
<form action="{{ route('login') }}" method="POST">
    @csrf

    <div class="input-group mb-3">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" placeholder="{{ __('Email') }}" required autofocus>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
        @error('email')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="input-group mb-3">
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="{{ __('Password') }}" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        @error('password')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="row mb-3">
        <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Sign In') }}
            </button>
        </div>
    </div>
</form>
@endsection

@section('auth_footer')
    @if (Route::has('admin.password.request'))
        <p class="my-0">
            <a href="{{ route('admin.password.request') }}">
                {{ __('I forgot my password') }}
            </a>
        </p>
    @endif

    @if (Route::has('admin.register'))
        <p class="my-0">
            <a href="{{ route('admin.register') }}" class="text-center">
                {{ __('Register a new membership') }}
            </a>
        </p>
    @endif
@endsection
