<?php

namespace App\Http\Controllers\Front;

// Post,Tagモデルを使用する
use App\Models\Post;
use App\Models\Tag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tagSlug = null)
    {
        // 公開・新しい順に表示
        // post.phpのpublicList()を実行して、DBからデータを取得する。
        // postsの値はpost.phpにて処理されたものが帰ってくる
        // 同じ様な処理が複数存在する場合、この様にscope化して使用する。
        $posts = Post::publicList($tagSlug);
        $tags = Tag::all();
        
        return view('front.posts.index', compact('posts', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

    // 引数のintはデータ型を指定している。
    public function show(int $id)
    {
        // post.phpでpublicFindByIdを実行し、DBからデータを取得する。
         $post = Post::publicFindById($id);
         return view('front.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
