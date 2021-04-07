<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Album example · Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

</head>
<body>
<header>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                <strong>Market.Place</strong>
            </a>
        </div>
        <div>
            <a href="" class="btn btn-light">Категории товаров</a>
        </div>
    </div>
</header>

<main role="main">

    <section class="jumbotron text-center">
        <div class="container">
            <h2>База оптовых поставщиков</h2>
            <p>В нашей базе более 3.000.000 поставщиков, 3.000.000 заказов ежедневно проходят через нашу площадку</p>
            <div class="form-group">
                <div class="row">
                    <div class="col-10">
                        <input type="text" placeholder="Найти товар" class="form-control">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-info">Найти</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1>Купить</h1>
                <p>Ускорьте процесс закупки, экономьте до 40%, выбирая из предложений 1.1 млн поставщиков. Это бесплатно.</p>
                <a href="" class="btn btn-success">Купить товар!</a>
            </div>
            <div class="col-6">
                <h1>Продать</h1>
                <p>Находите новых клиентов – ежедневно на нашей платформе размещают более 1000 заказов.</p>
                <a href="" class="btn btn-success">Разместить товар!</a>
            </div>
        </div>
    </div>


    <div class="album py-5 bg-light">
        <div class="container">
            <h1>Закупки наших клиентов</h1>
            <div class="row">

                @foreach($orders as $order)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img class="bd-placeholder-img card-img-top" height="150" src="{{$order->item->cover->file}}" alt="">
                            <div class="card-body">
                                <p class="card-text">{{$order->item->item_name}}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Подробнее</button>
                                    </div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans()  }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="album py-5 bg-light">
        <div class="container">
            <h1>Каталог товаров</h1>
            <div class="row">

                @foreach($items as $item)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img class="bd-placeholder-img card-img-top" height="150" src="{{$item->cover->file}}" alt="">
                            <div class="card-body">
                                <p class="card-text">{{\Illuminate\Support\Str::limit($item->description, "250", "...")}}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Подробнее</button>
                                    </div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans()  }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

</main>

<footer class="text-muted">
    <div class="container">
        <p class="float-right">
            <a href="#">Back to top</a>
        </p>
        <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
        <p>New to Bootstrap? <a href="https://getbootstrap.com/">Visit the homepage</a> or read our <a href="/docs/4.5/getting-started/introduction/">getting started guide</a>.</p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
</html>
