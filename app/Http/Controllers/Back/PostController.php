<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Post,Tag,Userモデルを使用
use App\Models\Post;
use App\Models\Tag;
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
        // 投稿を最新順に取り出す
        // 「N＋1問題」防止の為にwith('user')で、リレーションであるuserテーブルを取得。
        // リレーションテーブルのデータを取得する際は「N＋1問題」の防止策を講じる。 ※処理速度に影響が出る為
        $posts = Post::with('user')->latest('id')->paginate(20);
        // 公開・新しい順に表示

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
        // pluckメソッドを使用すれば、テーブルのあるカラムを配列にして取り出せる。
        // 今回はキーがidでバリューがnameのコレクションを生成。
        $tags = Tag::pluck('name', 'id')->toArray();
        return view('back.posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    public function store(PostRequest $request)
    {
        $post = Post::create($request->all());
        // 多対多のリレーションがある場合は、目的に応じてメソッドを使い分ける。
        // attachはデータ登録に用いる。データの重複は問題ない。
        $post->tags()->attach($request->tags);

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
        $tags = Tag::pluck('name', 'id')->toArray();
        return view('back.posts.create', compact('tags'));
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
        // 値を重複させずにデータを挿入できる。(同じデータがDBに入ったら困る時に使える)
        $post->tags()->sync($request->tags);

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
        // ポストテーブルに紐付いたtagテーブルのidが削除される。
        $post->tags()->detach();

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
