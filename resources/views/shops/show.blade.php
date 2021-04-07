@extends("layouts.blank")

@section("content")
<div class="container">
    <h1>{{$title}}</h1>
</div>
@if(!$phone_active)
    <div class="alert alert-danger">
        <h3>Ваш магазин не активирован!</h3>
            <p>Подтвердите номер мобильного телефона. После подтверждения магазин будет передан на модерацию!
                <a href="{{route("phone.activation", $shop_id)}}">Пройти подтверждение</a></p>
    </div>
@elseif(!$active && !$legal_information)
    <div class="alert alert-warning">
        <h3>Ваш магазин не активирован!</h3>
        <p>Вы можете ускорить процесс модерации указав ОГРН или ИНН вашей организации</p>
        <p><a href="{{route("legal.information", $shop_id)}}">Пройти подтверждение</a></p>
    </div>
@elseif(!$active && $legal_information)
    <div class="alert alert-info">
        <h3>Ваш магазин не активирован!</h3>
        <p>Мы постараемся его проверить как можно быстрее!</p>
    </div>
@endif
@if($is_owner)
    <a href="{{route("shop.edit", $shop_id)}}" class="btn btn-warning">Редактировать</a>
@endif
<p>{{$description}}</p>
<p>Web-сайт: {{$site}}</p>
<p>Время работы: {{$work_time}}</p>
<p>Минимальная сумма заказа: {{$min_price}}</p>
<p>Местонахождение: {{$country.' '.$city}}</p>
<hr/>
@if($legal_information)
    <ul>
        <li>ИНН: {{$legal_information->inn}}</li>
        <li>ОГРН(ОГРНИП): {{$legal_information->ogrn}}</li>
        @if($legal_information->kpp)
        <li>КПП: {{$legal_information->kpp}}</li>
        @endif
        <li>Руководитель: {{$legal_information->middle_name." ".$legal_information->firstname." ".$legal_information->surname}}</li>
        <li>Адрес: {{$legal_information->adress}}</li>
        <li>Дата регистрации: {{$legal_information->date_register}}</li>
    </ul>
@elseif($is_owner)
    <p>Вы можете вызвать большее доверие у покупателей, если укажите юридическую информацю о вашей организации!</p>
    <p><a href="{{route("legal.information", $shop_id)}}">Указать информацию</a></p>
@endif
<div class="row mb-2">
    @foreach($items as $item)
        <div class="col-md-6">
            <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-success">{{$item->category->category_name}}</strong>
                    <h3 class="mb-0">{{$item->item_name}}</h3>
                    <div class="mb-1 text-muted">{{$item->created_at}}</div>
                    <p class="mb-auto">{{\Illuminate\Support\Str::limit($item->description, 150, "...")}}</p>
                    <a href="{{\Illuminate\Support\Facades\URL::route("item.show", ["item_id" => $item->id])}}" class="stretched-link">Читать дальше</a>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <img src="{{\Illuminate\Support\Facades\URL::asset("storage/app/".$item->cover->filename)}}" width="200" height="250" alt="{{$item->item_name}}">
                </div>
            </div>
        </div>
    @endforeach
</div>
    {{$items->links()}}
@endsection
