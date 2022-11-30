@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="container">
        <div class="row">
            <nav aria-label="Breadcrumb" class="breadcrumb">
                <ul>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><span aria-current="page">{{ $article->name }}</span></li>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6 header">
                <h2>{{ $article->name }}</h2>
            </div>
        </div>
        <div class="row header-image">
            <img src="{{ $article->image }}">
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! $article->description !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-4 col-sm-4 col-lg-4 col-xl-4"><i class="fa fa-eye">{{ $article->views }}</i></div>
            <div class="offset-md-2 offset-2 offset-sm-2 offset-lg-2 offset-xl-2 col-md-6  col-6 col-sm-6 col-lg-6 col-xl-6" style="text-align: right"><i class="fa fa-user" aria-hidden="true">{{ $article->author->name }}</i> {{ Carbon\Carbon::parse($article->date_in)->format('Y-m-d') }}</div>
        </div>

        <div class="row other-articles-section">
            <div class="row read-also-header">
                <h2>Читайте також</h2>
            </div>
            @foreach($other_articles as $other_article)
                <div class="col-md-4 article-container">
                    <a href="{{ auth()->user()->role->alias == "free" && $other_article->paid_content ? '#' : '/blog/' . $other_article->slug }}" class="link">
                        <div class="image">
                            <img src="{{ $other_article->image }}" style="width: 100%; height: 207px; object-fit: cover;">
                        </div>
                        <div class="after-image-block">
                            <h3>{{ $other_article->name }}</h3>
                            <p>{{ $other_article->short_description }}</p>
                            <div class="row">
                                <div class="col-md-4 col-4 col-sm-4 col-lg-4 col-xl-4"><i class="fa fa-user" aria-hidden="true"> {{ $other_article->author->name }}</i></div>

                                <div class="offset-md-2 offset-2 offset-sm-2 offset-lg-2 offset-xl-2 col-md-6  col-6 col-sm-6 col-lg-6 col-xl-6" style="text-align: right"><i class="fa fa-eye">{{ $article->views }}</i></div>
                            </div>
                            <div class="row bottom-block">
                                <div class="col-md-4 col-4 col-sm-4 col-lg-4 col-xl-4 posted-date">{{ Carbon\Carbon::parse($other_article->date_in)->format('Y-m-d') }}</div>
                                @if(auth()->user()->role->alias == "free" && !$other_article->paid_content || auth()->user()->role->alias != "free")
                                    <div class="offset-md-3 offset-3 offset-sm-3 offset-lg-3 offset-xl-3 col-md-5  col-5 col-sm-5 col-lg-5 col-xl-5"><button class="btn btn-default read_more_btn">Читати більше</button></div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="/css/blog.css">
@endsection