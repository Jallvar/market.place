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

            <form class="" method="post" action="{{route('reset.password', ['token' => $token])}}">

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
                <input type="hidden" name="token" value="{{ $token }}">
                @csrf
                <div class="form-group ">
                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                    <button class="btn btn-primary btn-lg btn-block login-button">Установить новый пароль</button>
                </div>

            </form>
        </div>
    </div>
@endsection
