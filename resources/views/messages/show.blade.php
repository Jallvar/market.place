@extends("layouts.blank")
@section("content")
    <div class="content">
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
            @foreach($messages as $message)
                <div class="col-12">
                    <p>
                        <b>{{$message->user_from->short_name}}</b>
                        <p>{{$message->message}}</p>
                    </p>
                    @if($message->attachments)
                        @foreach($message->attachments as $attachment)
                            @if($attachment->type == "item")
                                <div class="panel">
                                    <h4>Прикрепленный товар</h4>
                                    <div class="row">
                                        <div class="col-4"><img src="{{\Illuminate\Support\Facades\URL::asset("storage/app/".$attachment->item->cover->value)}}" height="150"></div>
                                        <div class="col-8"><h3>{{$attachment->item->item_name}}</h3><p>{{$attachment->item->description}}</p></div>
                                    </div>
                                </div>
                            @elseif($attachment->type = "image")
                                <h4>Прикрепленное изображение</h4>
                                    <img height="250" src="{{$attachment->File}}" alt="">
                                @endif
                        @endforeach
                        @endif
                </div>
            @endforeach
        </div>
        <div class="col-12">
            <h2>Ответить</h2>
            <form action="{{route("messages.show", $user_id)}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="item_name" class="cols-sm-4 control-label">Текст сообщения</label>
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
                @csrf
                <button class="btn btn-primary" type="submit">Отправить сообщение</button>
            </form>
        </div>
    </div>
@endsection
