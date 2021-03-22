<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Post,Userモデルを使用
use App\Models\Post;
use App\Models\User;
// バリデーションの値を取得するpath
use App\Http\Requests\PostRequest;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // created_atの最新順に取り出す
        $posts = Post::latest('id')->paginate(20);
        // compactで複数の変数をviewへ。今回は単一の変数。※withは変数
        return view('back.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create($request->all());

        // もしバリデーションした値が$postにあれば(true)、登録成功アナウンス→投稿編集画面へ
        if ($post) {
            return redirect()
                ->route('back.posts.edit', $post)
                ->withSuccess('データを登録しました。');
        // もしバリデーションに引っ掛かり$postにデータがなければ(false)、登録失敗アナウンス→登録画面へ
        } else {
            return redirect()
                ->route('back.posts.create')
                ->withError('データの登録に失敗しました。');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // 各投稿の編集画面
        return view('back.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
    //   登録処理と同じくバリエーション次第
      if ($post->update($request->all())) {
        $flash = ['success' => 'データを更新しました。'];
    } else {
        $flash = ['error' => 'データの更新に失敗しました'];
    }
 
    return redirect()
        ->route('back.posts.edit', $post)
        ->with($flash);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // idを取得して、当該のレコードを削除
    if ($post->delete()) {
        $flash = ['success' => 'データを削除しました。'];
    } else {
        $flash = ['error' => 'データの削除に失敗しました'];
    }
 
    return redirect()
        ->route('back.posts.index')
        ->with($flash);
    }
}
