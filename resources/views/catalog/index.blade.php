@extends("layouts.blank")

@section("content")
<div class="container">
    <div class="row">
        @foreach($categories as $category)
            <div class="col-4">
                <h3>{{$category->name}}</h3>
                @foreach($category->children as $children)
                    <a href="{{route("catalog.category", ["category_id" => $children->id])}}"><p>{{$children->name}}</p></a>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection
