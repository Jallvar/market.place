@extends("layouts.blank")
@section("content")
    <div class="container">
        <div><form action="{{@route("search")}}" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-10">
                            <input type="text" name="query" value="{{@old("query")}}" placeholder="Найти товар" class="form-control">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-info">Найти</button>
                        </div>
                    </div>
                </div>
                @csrf
            </form>
        </div>
        <div>
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
                            <img src="{{\Illuminate\Support\Facades\URL::asset("storage/app/".$item->cover->value)}}" width="200" height="250" alt="{{$item->item_name}}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
