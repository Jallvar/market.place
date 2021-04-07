@extends("layouts.blank")
@section("content")
    <div class="row">
        <div class="col-3">
            <p><h3>{{$shop->shop_name}}</h3></p>
            <img src="{{\Illuminate\Support\Facades\URL::asset("storage/app/".$shop->logo)}}">
            <p>{{\Illuminate\Support\Str::limit($shop->description, "250", "...")}}</p>
        </div>
        <div class="col-9">
            <p><h2>{{$item_name}}</h2></p>
            <div class="row">
                <div class="col-6">
                    <p>Категория: {{$category}}</p>
                    <p>Доставка:
                    <ul>
                        @foreach($deliveries as $delivery)
                            <li>{{$delivery->name}}</li>
                        @endforeach
                    </ul>
                    </p>
                </div>
                <div class="col-6">
                    <p>Регион: {{$country}}, {{$city}}</p>
                </div>
            </div>
            <img height="250" src="{{\Illuminate\Support\Facades\URL::asset("storage/app/".$cover->value)}}">
            <p>{{$description}}</p>
            <a class="btn btn-success" href="{{route("messages.order", $item_id)}}">Заказать товар</a>

            <h2>Галлерея</h2>

            <div class="row">
                @foreach($attachments as $image)
                    <div class="col-4"><img height="175" src="{{\Illuminate\Support\Facades\URL::asset("storage/app/".$image->value)}}"></div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
