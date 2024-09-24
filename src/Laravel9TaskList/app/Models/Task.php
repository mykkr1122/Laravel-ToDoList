<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = [
        'title',
        'status',
        'due_date',
    ];

    use HasFactory;

    /**
     * ステータス（状態）定義
     * const：定数
     */
    const STATUS = [
        1 => ['label' => '未着手', 'class' => 'label-danger'],
        2 => ['label' => '着手中', 'class' => 'label-info'],
        3 => ['label' => '完了', 'class' => ''],
    ];

    /**
     * ステータス（状態）ラベルのアクセサメソッド
     * 
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        // ステータス（状態）カラムの値を取得する
        $status = $this->attributes['status'];

        // STATUSに定義されていない場合
        if (!isset(self::STATUS[$status])) {
            // 空文字を返す
            return '';
        }
        // STATUSの値（['label']）を返す
        return self::STATUS[$status]['label'];
    }

    /**
     * 状態を表すHTMLクラスのアクセサメソッド
     * 
     * @return string
     */
    public function getStatusClassAttribute()
    {
        // ステータス（状態）カラムの値を取得する
        $status = $this->attributes['status'];

        // STATUSに定義されていない場合
        if (!isset(self::STATUS[$status])) {
            // 空文字を返す
            return '';
        }
        // STATUSの値（['class']）を返す
        return self::STATUS[$status]['class'];
    }

    /**
     * 期限日のフォーマットを設定するメソッド
     * @return string
     */
    public function getFormattedDueDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])
            ->format('Y/m/d');
    }
}
