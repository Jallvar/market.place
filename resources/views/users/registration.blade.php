@extends("layouts.blank")

@section("content")
<div class="container">
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

        <form class="" method="post" action="{{route('registration')}}">

            <div class="form-group">
                <label for="name" class="cols-sm-4 control-label">Ваше имя</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Введиье ваще имя"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="cols-sm-4 control-label">Фамилия</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="surname" id="surname" value="{{ old('surname') }}" placeholder="Введите вашу фамилию"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="cols-sm-4 control-label">Отчество</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ old('middle_name') }}" placeholder="Введите ваше отчество"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="cols-sm-4 control-label">Ваш e-mail</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="email" id="email" value=" {{ @old('email') }}" placeholder="Enter your Email"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="cols-sm-4 control-label">Password</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm" class="cols-sm-4 control-label">Confirm Password</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm your Password"/>
                    </div>
                </div>
            </div>
            @csrf
            <div class="form-group">
                <label for="confirm" class="cols-sm-4 control-label">Я регистрируюсь как продавец</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="checkbox" class="form-control" name="seller" id="seller" checked="{{@old("seller")}}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm" class="cols-sm-4 control-label">Я согласен с правилами</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="checkbox" class="form-control" name="terms" id="terms"/>
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                <button class="btn btn-primary btn-lg btn-block login-button">Регистрация</button>
            </div>

        </form>
    </div>
</div>
@endsection
