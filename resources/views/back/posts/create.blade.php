<?php
$title = '投稿登録';
?>
@extends('back.layouts.base')
 
@section('content')
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
    <!-- Form::open ::close (フォームタグ)  -->
        {{ Form::open(['route' => 'back.posts.store']) }}
        <!-- 編集画面同様のフォームを呼び出す -->
        @include('back.posts._form')
        {{ Form::close() }}
    </div>
@endsection