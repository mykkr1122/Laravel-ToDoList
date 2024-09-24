<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    // テーブル名を明示的に指定する
    protected $table = 'folders';

    /**
     * Run the migrations.
     * foldersテーブルと各列を作成する
     * 
     * @return void
     */
    public function up()
    {
        /**
         * folders Table create
         * column1 -> カラム名：id, 型：INTEGER, オプション：AI
         * column2 -> カラム名：title, 型：VARCHAR(20)
         * column3 -> カラム名：created_at, 型：TIMESTAMP
         * column4 -> カラム名：updated_at, 型：TIMESTAMP
         */
        Schema::create('folders', function (Blueprint $table) {
            // UNSIGNED INTEGER（主キー）の同等の列を自動インクリメントする
            $table->increments('id');
            // オプションの長さのVARCHAR相当の列を追加する
            $table->string('title', 20);
            // created_atとupdated_atのTIMESTAMPに相当する列を追加する
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * foldersテーブルを削除する
     * 
     * @return void
     */
    public function down()
    {
        // foldersテーブルを削除する
        Schema::dropIfExists('folders');
    }
}