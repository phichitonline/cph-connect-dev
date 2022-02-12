@extends('layouts.theme')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<!-- Begin of Page Content-->
<div class="page-content header-clear-small">

<form id="login-form" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="card card-style">
        <div class="content mt-4 mb-0">
            <h1 class="text-center font-900 font-40 text-uppercase mb-0">Login</h1>
            {{-- <p class="bottom-0 text-center color-highlight font-11">Let's get you logged in</p> --}}

            <div class="input-style has-icon input-style-1 input-required pb-1 @error('email') is-invalid @enderror">
                <i class="input-icon fa fa-user color-theme"></i>
                <span>Email</span>
                <em>(required)</em>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="Email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-style has-icon input-style-1 input-required pb-1 @error('password') is-invalid @enderror">
                <i class="input-icon fa fa-lock color-theme"></i>
                <span>Password</span>
                <em>(required)</em>
                <input id="password" type="password" name="password" placeholder="Password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <a href="#" onclick="event.preventDefault();
            document.getElementById('login-form').submit();"
            class="btn btn-m mt-2 mb-4 btn-full bg-green1-dark text-uppercase font-900">Login</a>

            <div class="divider mt-4 mb-3"></div>

        </div>

    </div>
</form>


</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')


@endsection

