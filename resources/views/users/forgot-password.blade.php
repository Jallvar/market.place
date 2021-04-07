@extends("layouts.blank")

@section("content")
    <h1>Забыли пароль?</h1>
    <p>Лох это судьба. Но ничего, введи свой емайл и мы его тебе отправим</p>
    <div class="container">
        @if(\Illuminate\Support\Facades\Session::has("status"))
            <div class="alert alert-success">
                На ваш email было отправлено сообщение с ссылкой для восстановления пароля!
            </div>
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
        <div class="row main-form">

            <form class="" method="post" action="{{route('forgot.password')}}">

                <div class="form-group">
                    <label for="email" class="cols-sm-4 control-label">Ваш e-mail</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="email" id="email" value=" {{ @old('email') }}" placeholder="Enter your Email"/>
                        </div>
                    </div>
                </div>

                @csrf
                <div class="form-group ">
                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                    <button class="btn btn-primary btn-lg btn-block login-button">Отправить ссылку</button>
                </div>

            </form>
        </div>
    </div>
@endsection
