@extends('layouts.theme')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<!-- Begin of Page Content-->
<div class="page-content header-clear-small">

<form id="register-form" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="card card-style">
        <div class="content mb-0">
            <h1 class="text-center font-900 font-40 text-uppercase mb-0">REgister</h1>
            {{-- <p class="text-center color-highlight font-11">Don't have an account? Register here.</p> --}}

            <div class="input-style has-icon input-style-1 input-required @error('name') is-invalid @enderror">
                <i class="input-icon fa fa-user color-theme"></i>
                <span>Name</span>
                <em>(required)</em>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-style has-icon input-style-1 input-required @error('email') is-invalid @enderror">
                <i class="input-icon fa fa-at color-theme"></i>
                <span>Email</span>
                <em>(required)</em>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-style has-icon input-style-1 input-required @error('password') is-invalid @enderror">
                <i class="input-icon fa fa-lock color-theme"></i>
                <span>Password</span>
                <em>(required)</em>
                <input id="password" type="password" name="password" placeholder="Password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-style has-icon input-style-1 input-required mb-4">
                <i class="input-icon fa fa-lock color-theme"></i>
                <span>Password</span>
                <em>(required)</em>
                <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required>
            </div>

            <a href="#" onclick="event.preventDefault();
            document.getElementById('register-form').submit();"
            class="btn btn-m mt-2 mb-4 btn-full bg-green1-dark text-uppercase font-900">Create account</a>

        </div>
    </div>
</form>

</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')


@endsection
