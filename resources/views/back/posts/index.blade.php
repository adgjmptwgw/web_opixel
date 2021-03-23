<?php
$title = '投稿一覧';
?>
@extends('back.layouts.base')
 
@section('content')
<div class="card-header">投稿一覧</div>
<div class="card-body">
    <!-- 投稿登録処理 -->
    {{ link_to_route('back.posts.create', '新規登録', null, ['class' => 'btn btn-primary mb-3']) }}
    <!-- もし投稿があれば表示する -->
    @if(0 < $posts->count())
        <table class="table table-striped table-bordered table-hover table-sm">
        <!-- postsテーブルの各カラム -->
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">タイトル</th>
                    <th scope="col" style="width: 4.3em">状態</th>
                    <th scope="col" style="width: 9em">公開日</th>
                    <th scope="col">編集者</th>
                    <th scope="col" style="width: 12em">編集</th>
                </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->is_public_label }}</td>
                    <td>{{ $post->published_format }}</td>
                    <td>{{ $post->user->name }}</td> 
                    <td class="d-flex justify-content-center">
                        <!-- 投稿詳細参照ボタン -->
                        {{ link_to_route('front.posts.show', '詳細', $post, [
                            'class' => 'btn btn-secondary btn-sm m-1',
                            'target' => '_blank'
                        ]) }}
                        <!-- 投稿編集ページへ画面遷移 -->
                        {{ link_to_route('back.posts.edit', '編集', $post, [
                            'class' => 'btn btn-secondary btn-sm m-1'
                        ]) }}
                        <!-- 投稿削除処理 -->
                        {{ Form::model($post, [
                            'route' => ['back.posts.destroy', $post],
                            'method' => 'delete'
                        ]) }}
                        <!-- 削除ボタンとアナウンス -->
                            {{ Form::submit('削除', [
                                'onclick' => "return confirm('本当に削除しますか?')",
                                'class' => 'btn btn-danger btn-sm m-1'
                            ]) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- ページナビゲーション -->
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection