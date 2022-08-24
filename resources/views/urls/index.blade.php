@extends('app')

@section('title', 'Список сайтов')

@section('content')

<div class="container-lg">
    <h1 class="mt-5 mb-3">Сайты</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Последняя проверка</th>
                <th>Код ответа</th>
            </tr>
            @foreach($urls as $url)
            <tr>
                <td>{{$url->id}}</td>
                <td><a href="/urls/{{$url->id}}">{{$url->name}}</a></td>
                <td>{{$url->last_check}}</td>
                <td>{{$url->status_code}}</td>
            </tr>
            @endforeach
        </table>
        
        <nav class="d-flex justify-items-center justify-content-between">
            <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                <div>
                    <p class="small text-muted">
                        Showing
                        <span class="font-medium">{{ $urls->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $urls->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $urls->total() }}</span>
                        results
                    </p>
                </div>
                <div>
                    {{ $urls->links() }}
                </div>
            </div>
        </nav>
    </div>
</div>

@endsection