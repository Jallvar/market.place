@extends("layouts.blank")
@section("content")
    <div class="container">
        <h2>Сообщения</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">От кого</th>
                <th scope="col">Дата</th>
                <th scope="col">Сообщение</th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr class='clickable-row' data-href='{{route("messages.show", $message->user_from_id)}}'>
                    <td>{{$message->user_from->short_name}}</td>
                    <td>{{$message->updated_at}}</td>
                    <td>{{\Illuminate\Support\Str::limit($message->message, 150, "..")}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <style>
        .clickable-row:hover {
            background-color: #0f6674;
        }
    </style>
    <script>
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>
@endsection
