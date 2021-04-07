@foreach($items as $item)
    <div class="col-4">
        <img src="{{\Illuminate\Support\Facades\URL::asset("storage/app/".$item->cover->value)}}" height="150" width="150" alt="{{$item->item_name}}">
    </div>
@endforeach
