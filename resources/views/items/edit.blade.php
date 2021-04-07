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
            <form class="" method="post" action="{{route("item.edit", ["item_id" => $item_id])}}" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="item_name" class="cols-sm-4 control-label">Название товара</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="item_name" id="item_name" value="{{old("item_name", $item_name)}}" placeholder="Введите название товара"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="cols-sm-4 control-label">Описание товара</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{old("description", $description)}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="quantity" class="cols-sm-4 control-label">Минимальное количество товара для покупки</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="quantity" id="quantity"  value="{{old("quantity", $quantity)}}" placeholder="Введите минимальное количество товара для покупки"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="price" class="cols-sm-4 control-label">Цена</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="price" id="price"  value="{{old("price", $price)}}" placeholder="Введите цену товара"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category_id" class="cols-sm-4 control-label"></label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <select name="category_id" id="category_id">
                                @include("items.categories-edit", ["categories" => $categories, "category_id" => $category_id])
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cover" class="cols-sm-4 control-label">Загрузите изображения товара</label>
                    <div class="cols-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="file" name="attachments[]" multiple></div>
                    </div>
                </div>

                <div class="row">
                    @foreach($attachments as $image)
                        <div class="col-4"><img height="175" src="{{\Illuminate\Support\Facades\URL::asset("storage/app/".$image->value)}}"></div>
                    @endforeach
                </div>

                @csrf

                <div class="form-group ">
                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                    <button class="btn btn-primary btn-lg btn-block login-button">Изменить товар</button>
                </div>

            </form>
        </div>
    </div>
@endsection
