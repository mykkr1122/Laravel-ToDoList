<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    // テーブル名を明示的に指定する
    protected $table = 'tasks';

    /**
     * Run the migrations.
     * tasksテーブルと各列を作成する
     *
     * @return void
     */
    public function up()
    {
        /**
         * tasks Table create
         * column1 -> カラム名：id, 型：INTEGER, オプション：AI
         * column2 -> カラム名：folder_id, 型：INTEGER
         * column3 -> カラム名：title, 型：VARCHAR(100)
         * column4 -> カラム名：due_date, 型：DATE
         * column5 -> カラム名：status, 型：INTEGER, デフォルト：1（未着手）
         * column6 -> カラム名：created_at, 型：TIMESTAMP
         * column7 -> カラム名：updated_at, 型：TIMESTAMP
         */
        Schema::create('tasks', function (Blueprint $table) {
            // UNSIGNED INTEGER（主キー）の同等の列を自動インクリメントする
            $table->increments('id');
            // INTEGER相当の列をUNSIGNED（MySQL）として追加する。
            $table->integer('folder_id')->unsigned();
            // オプションの長さのVARCHAR相当の列を追加する
            $table->string('title', 100);
            // DATEに相当する列を追加する
            $table->date('due_date');
            // INTEGER相当の列を追加してデフォルトの値に「1」をセットする
            $table->integer('status')->default(1);
            // created_atとupdated_atのTIMESTAMPに相当する列を追加する
            $table->timestamps();

            /* 外部キーを'folder_id'列に設定する（実在するIDの値以外はDBに入らないようにする） */
            // foreign()：外部キーを設定する列を指定する
            // ->references()：参照する列名を指定する
            // ->on()：参照するテーブル名を指定する
            $table->foreign('folder_id')->references('id')->on('folders');
        });
    }

    /**
     * Reverse the migrations.
     * tasksテーブルを削除する
     *
     * @return void
     */
    public function down()
    {
        // tasksテーブルを削除する
        Schema::dropIfExists('tasks');
    }
}