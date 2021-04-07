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
        <div class="row">
            <div class="col-4"><img src="{{\Illuminate\Support\Facades\URL::asset("storage/app/".$cover)}}" height="150"></div>
            <div class="col-8"><h3>{{$item_name}}</h3><p>{{$description}}</p></div>
        </div>

        <form action="{{route("messages.storeOrder")}}" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="item_name" class="cols-sm-4 control-label">Опишите ваши пожелания к заказу</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <textarea class="form-control" name="message" id="message">{{old("message")}}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="cover" class="cols-sm-4 control-label"><p>Прикрепить вложения (Office документы, изображения)</p><p>Максимум 3 файла по 5 мб</p></label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="file" name="attachments[]" multiple></div>
                </div>
            </div>
            <input type="hidden" name="item_id" value="{{$item_id}}">
            @csrf
            <button class="btn btn-primary" type="submit">Отправить сообщение</button>
        </form>
    </div>
@endsection
