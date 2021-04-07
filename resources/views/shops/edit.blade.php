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

            <form class="" method="post" action="{{@route("shop.edit", $shop_id)}}" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="name" class="cols-sm-4 control-label">Название вашего магазина</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="name_shop" id="name_shop" value="{{ old('name_shop', $name_shop) }}" placeholder="Введиье название магазина"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="cols-sm-4 control-label">Описание</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                            <textarea class="form-control" name="description" id="" cols="30" rows="10" placeholder="Введите описание магазина">
                                {{old("description", $description)}}
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="cols-sm-4 control-label">Номер телефона</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $phone) }}" placeholder="Введите ваш номер телефона"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="cols-sm-4 control-label">Ваш e-mail</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="email" id="email" value=" {{ old('email', $email) }}" placeholder="Enter your Email"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="cols-sm-4 control-label">Веб-сайт</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="site" id="site" value="{{old("site", $site)}}" placeholder="Введите адрес сайта"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm" class="cols-sm-4 control-label">Время работы</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="work_time" id="work_time" value="{{old("work_time", $work_time)}}" placeholder="Время работы магазина"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm" class="cols-sm-4 control-label">Минимальная цена покупки</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" name="min_price" id="min_price" value="{{old("work_time", $min_price)}}" placeholder="Введите цену"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm" class="cols-sm-4 control-label">Выберите ваш город</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <select class="form-control" name="city">
                                @foreach ($countries as $country)
                                <optgroup label="{{$country->name}}">
                                    @foreach($country->cities as $row)
                                        <option value="{{$row->id}}" {{$city == $row->id ? "selected":""}}>{{$row->name}}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm" class="cols-sm-4 control-label">Загрузить логотип магазина</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="file" name="logo">                        </div>
                    </div>
                </div>


                @csrf
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
                    <button class="btn btn-primary btn-lg btn-block login-button">Создать магазин</button>
                </div>

            </form>
        </div>
    </div>
@endsection
