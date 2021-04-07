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
            @if (\Illuminate\Support\Facades\Session::has("message"))
                <div class="alert alert-warning">
                    <p>{{\Illuminate\Support\Facades\Session::get("message")}}</p>
                </div>
            @endif
        <div class="row main-form">

            <form class="" method="post" action="{{route('legal.information', ['shop_id' => $shop_id])}}">

                <div class="form-group">
                    <label for="email" class="cols-sm-4 control-label">Введите ваш ОГРН</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="ogrn" id="ogrn" value=" {{ old('ogrn', $ogrn) }}" placeholder="Введите ваш ОГРН"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm" class="cols-sm-4 control-label">Я даю разрешение на обработку моих персональных данных</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="checkbox" class="form-control" name="terms" id="terms"/>
                        </div>
                    </div>
                </div>

                @csrf
                <div class="form-group ">
                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                    <button class="btn btn-primary btn-lg btn-block login-button">Обновить юридическую информацию</button>
                </div>

            </form>
        </div>
    </div>
@endsection
