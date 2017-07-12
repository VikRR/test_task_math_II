@extends('layouts.app')

@section('content')
    <div class="content">
        @foreach($data as $news)
            <div class="news" style="background-image: url({{$news['image']}})">
                <h3 class="news-title">{{$news['title']}}</h3>
                <p class="news-description">{{$news['description']}}</p>
            </div>
        @endforeach
    </div>
@endsection