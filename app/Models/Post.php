<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Builderを使用する際に下記追記
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string|null $body
 * @property bool $is_public
 * @property \Illuminate\Support\Carbon $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory;

    // Userテーブルとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Tagテーブルとのリレーション
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    protected static function boot()
   {
    // parentで指定のクラスを実行させる
    parent::boot();
 
    // 新規投稿及び投稿編集時に自動で編集者をログインユーザーに設定する
    self::saving(function($post) {
        $post->user_id = \Auth::id();
    });
   }

    // fillable・・・指定したカラムのみ取得、使用する。
    protected $fillable = [
        'title', 'body', 'is_public', 'published_at'
    ];
    // DBからデータを取り出す際はデータの型を持っていない。(全てStringで取得される。)
    // castsを用いれば、DBから取り出すデータに型を付ける事ができる。
    protected $casts = [
        'is_public' => 'bool',
        'published_at' => 'datetime'
    ];

    // 公開のみ表示(公開設定である、is_publicがtrueのものだけを取得)
    public function scopePublic(Builder $query)
    {
        return $query->where('is_public', true);
    }
 
    // 記事の一覧画面のデータを全て取得 (公開記事一覧取得)
    public function scopePublicList(Builder $query, string $tagSlug = null)
    {
        if ($tagSlug) {
            // リレーション先のカラムも取得したい場合にwhereHasを用いる。
            $query->whereHas('tags', function($query) use ($tagSlug) {
                $query->where('slug', $tagSlug);
            });
        }
        return $query
            ->with('tags')
            ->public()
            ->latest('published_at')
            ->paginate(10);
        }
 
    // 詳細の記事のデータを取得する処理 (公開記事をIDで取得)
    public function scopePublicFindById(Builder $query, int $id)
    {
        // find()       もし該当するデータが無かった場合、nullを返す
        // findOrFail() もし該当するデータが無かった場合、404 | Not Found 画面へ(通常ユーザ向け)
        return $query->public()->findOrFail($id);
    }

    // 公開日を年月日で表示
    // getAattributeを使えば、viewでpublished_atを呼び出す時に年/月/日が割り当てられた状態で表示される。
    // {{ $post->published_format }}  ←viewでの呼び出し方
    public function getPublishedFormatAttribute()
    {
        return $this->published_at->format('Y年m月d日');
    }

}
