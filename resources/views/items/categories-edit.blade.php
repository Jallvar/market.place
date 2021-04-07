@foreach($categories as $category)
    <option value="{{$category->id}}" @if($category->id == $category_id) selected @endif >{{$category->name}}</option>
    @if($category->children)
        @include("items.categories-edit", ["categories" => $category->children, "category_id" => $category_id])
    @endif
@endforeach
