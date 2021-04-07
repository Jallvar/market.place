@extends("layouts.blank")
@section("content")
<div class="container">
    <div>
        <h2>Поиск по товарам</h2>
    </div>
    <section class="jumbotron text-center">
        <div class="container">
            <h2>База оптовых поставщиков</h2>
            <p>В нашей базе более 3.000.000 поставщиков, 3.000.000 заказов ежедневно проходят через нашу площадку</p>
            <form action="{{@route("search")}}" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-10">
                            <input type="text" name="query" placeholder="Найти товар" class="form-control">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-info">Найти</button>
                        </div>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </section>
    <div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection
