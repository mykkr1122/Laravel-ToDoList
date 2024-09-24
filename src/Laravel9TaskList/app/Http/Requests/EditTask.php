<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Validation\Rule;

class EditTask extends CreateTask
{
    /**
     * バリデーションルールを定義するメソッド
     *
     * @return array
     */
    public function rules()
    {
        $rule = parent::rules();
        /* 状態の入力値が許可リストに含まれているか検証して出力する -> 'in(1, 2, 3)' を出力する */
        // Rule::in()：入力値が許可リストに含まれているか検証するRuleクラスのinメソッド
        // array_keys(Task::STATUS)：STATUSのkey（1, 2, 3）を取得する
        $status_rule = Rule::in(array_keys(Task::STATUS));

        return $rule + [
            /* 状態の入力ステータス（1, 2, 3）を入力必須にする -> 'status' => required|in(1, 2, 3), */
            'status' => 'required|' . $status_rule,
        ];
    }

    /**
     * リクエストのnameなどの値を再定義するメソッド
     *
     * @return array<string>
     */
    public function attributes()
    {
        $attributes = parent::attributes();

        return $attributes + [
            // 状態のリクエストを再定義する
            'status' => '状態',
        ];
    }

    /**
     * FormRequestクラス単位でエラーメッセージを定義するメソッド
     *
     * @return array<string>
     */
    public function messages()
    {
        $messages = parent::messages();
        /* Task::STATUS の各要素から label キーの値のみ取り出して配列を作成する */
        // array_map(関数名, 配列名)：配列のすべての要素に対して同じ処理を一括で適用する関数
        // このarray_map()では コールバック関数に無名関数を入れて自身の関数を一括で適用している
        $status_labels = array_map(function($item){
            return $item['label'];
        }, Task::STATUS);

        /* $status_labelsでlabel キーの値のみ取り出して作った配列を句読点で繋げる */
        // implode(区切り文字, 配列名)：配列の要素を区切り文字を付けて文字列にする
        $status_labels = implode('、', $status_labels);

        return $messages + [
            /* status の in ルールに違反した場合にエラーメッセージを出力する -> 状態 には 未着手、着手中、完了 のいずれかを指定してください。 */
            // 'status.in''項目名.ルール内容'
            'status.in' => ':attribute には' . $status_labels . 'のいづれかを指定してください。'
        ];
    }
}
