@extends('layouts.blank')
@section('content')
<div class="container">
    <div class="col-6">
        <form class="form-signin" method="post" action="{{@route("login")}}">
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
            </div>

            @if(\Illuminate\Support\Facades\Session::has("message"))
                <p class="alert alert-danger">{{ \Illuminate\Support\Facades\Session::get('message') }}</p>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-label-group">
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" value="{{@old('email')}}" required autofocus>
                <label for="inputEmail">Email address</label>
            </div>

            <div class="form-label-group">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            @csrf
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <p><a href="">Регистрация</a></p>
            <p><a href="">Забыли пароль?</a></p>
        </form>
    </div>
</div>
@endsection
