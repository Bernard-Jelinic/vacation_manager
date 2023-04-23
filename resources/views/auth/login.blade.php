@extends('layouts.app')

@section('content')

<style>
    body {
        background-image: url("assets/img/pngtree-summer-beach-summer-vacation-advertising-background-image_162086.jpg");
        height: 100vh;
        background-size: cover;
    }

    .login_form{
        max-width: 520px;
        width:100%;
        background: #333;
        color: #fff;
        left: 50%;
        position: absolute;
        transform: translate(-50%,100%);
        box-sizing: border-box;
        border-radius: 15px;
        opacity: 0.9;
    }
</style>

<div class="login_form container-fluid col-lg-5">

    <form method="POST" action="{{ route('login') }}"><br>

        <span style="font-size:12px;color:red;">
            @if ($errors->all())
                <div class="alert alert-danger text-center">
                    @foreach ($errors->all() as $error)
                        {{$error}}<br>
                    @endforeach
                </div>
            @endif
        </span>

        <h3 class="centered">Login</h3><br>

        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label>Email address</label>
            <input id="email" type="email" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label>Password</label>
            <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        </div>
        
        <div class="col text-center">
            <button type="submit" class="btn btn-primary" style="margin-bottom: 15px">{{ __('Login') }}</button>
        </div>

    </form>
</div>

@endsection