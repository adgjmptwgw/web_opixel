<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /**
         * 認証関係の判定を行う場合はここに処理を記述する。
         * 特にない場合は常にtrueを返しておく。
         */ 
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // バリデーションの条件・処理
        return [
            'title' => 'required|max:30',
            'body' => 'max:1000',
            'is_public' => 'required|numeric',
            'published_at' => 'required|date_format:Y-m-d H:i',
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        // ルールメソッドで指定したバリデーションで，エラーが返ってきたときにのメッセージの項目名をここで設定
        return [
            'title' => 'タイトル',
            'body' => '内容',
            'is_public' => 'ステータス',
            'published_at' => '公開日',
        ];
    }
}
