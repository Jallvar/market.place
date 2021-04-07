@extends("layouts.blank")

@section("content")
    <div class="container">
        @if (session()->has("message"))
            <div class="alert alert-info">
                {{session()->get("message")}}
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

            <form class="" method="post" action="{{route("phone.activation", $shop_id)}}">

                <div class="form-group">
                    <label for="name" class="cols-sm-4 control-label">На указанный вами номер телефона поступит звонок. <br/>Введите последние 6 цифр номера телефона</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="phone_code" id="phone_code" placeholder="6 цифр номера телефона с которого поступил звонок"/>
                        </div>
                    </div>
                </div>
                @csrf
                <p><a href="{{route("resend.code", $shop_id)}}">Запросить код</a></p>
                <div class="form-group ">
                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                    <button class="btn btn-primary btn-lg btn-block login-button">Подтвердить телефон</button>
                </div>

            </form>
        </div>
    </div>
@endsection
