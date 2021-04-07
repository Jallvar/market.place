@extends("layouts.blank")

@section("content")
    <script type="text/javascript">
        $(document).ready(function(){
            $('#btn-filter').click(function(){
                $.ajax({
                    url: '{{route("ajax.category")}}',
                    method: 'post',
                    data: {
                        category_id: {{$category_id}},
                        city_id: $("#city_id").val(),
                        delivery_id: $("#delivery_id").val(),
                        min_price: $("#min_price").val(),
                        max_price: $("#max_price").val(),
                        _token: "{{csrf_token()}}"
                    },
                    dataType : "html",                     // тип загружаемых данных
                    success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                        $("#category_list").html(data);
                    }
                });
            })
        });
    </script>
    <div class="row">
        <div class="col-3">
            <p>Регион</p>
            <select class="form-control" name="city_id" id="city_id">
                @foreach ($countries as $country)
                    <optgroup label="{{$country->name}}">
                        <option value="-1">Выберите город</option>
                        @foreach($country->cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            <p>Способ доставки</p>
            <select class="form-control" name="delivery_id" id="delivery_id">
                <option value="-1">Выберите способ доставки</option>
                @foreach($deliveries as $delivery)
                    <option value="{{$delivery->id}}">{{$delivery->name}}</option>
                @endforeach
            </select>
            <p>Введите цену:</p>
            <input class="form-control" type="text" name="min_price" id="min_price" value="{{$price_min}}">
            <input class="form-control" type="text" name="max_price" id="max_price" value="{{$price_max}}">
            <button id="btn-filter" class="btn btn-info">Применить</button>
            <a href="{{route("catalog.reset")}}" class="btn btn-warning">Сбросить</a>
        </div>
        <div class="col-9">
            <h2>{{$category_name}}</h2>
                <div class="row" id="category_list">
                    @include("catalog.category-list", $items)
                </div>
        </div>
    </div>

@endsection
