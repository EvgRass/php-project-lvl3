@extends('app')

@section('title', 'Анализ страницы')

@section('content')

<div class="container-lg">
    <h1 class="mt-5 mb-3">Сайт: {{$url->name}}</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <td>ID</td>
                <td>1</td>
            </tr>
            <tr>
                <td>Имя</td>
                <td>{{$url->name}}</td>
            </tr>
            <tr>
                <td>Дата создания</td>
                <td>{{$url->created_at}}</td>
            </tr>
        </table>
    </div>
    <h2 class="mt-5 mb-3">Проверки</h2>
    <form method="post" action="/urls/1/checks">
        @csrf           
        <input type="submit" class="btn btn-primary" value="Запустить проверку">
    </form>
    <table class="table table-bordered table-hover text-nowrap">
        <tr>
            <th>ID</th>
            <th>Код ответа</th>
            <th>h1</th>
            <th>title</th>
            <th>description</th>
            <th>Дата создания</th>
        </tr>
        <tr>
            <td>1</td>
            <td>200</td>
            <td>Online pro...</td>
            <td>Programming education: online...</td>
            <td>Live online community of progr...</td>
            <td>2022-08-02 16:37:54</td>
        </tr>
    </table>
</div>

@endsection