@extends('layouts.app')

@section('title',"Блог. Останні світлини.")

@section('content')
    <div class="container">
        <div class="row">
            <nav aria-label="Breadcrumb" class="breadcrumb">
                <ul>
                    <li><span aria-current="page">Blog</span></li>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6 header">
                <h2>Наш блог</h2>
            </div>
        </div>
        <admin-blog-page></admin-blog-page>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="/css/blog.css">
@endsection