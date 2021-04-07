@foreach($categories as $category)
    <option value="{{$category->id}}">{{$category->name}}</option>
    @if($category->children)
        @include("items.categories-create", ["categories" => $category->children])
    @endif
@endforeach
