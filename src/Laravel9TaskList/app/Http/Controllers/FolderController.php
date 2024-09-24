<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Http\Requests\CreateFolder;
use App\Http\Requests\EditFolder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    /**
     *  【フォルダ作成ページの表示機能】
     *
     *  GET /folders/create
     *  @return \Illuminate\View\View
     */
    public function showCreateForm()
    {
        // ログインユーザーに紐づくフォルダだけを取得
        $folders = Auth::user()->folders;
        return view('folders/create', compact('folders'));
    }

    /**
     *  【フォルダの作成機能】
     *  
     *  POST /folders/create
     *  @param Request $request （リクエストクラスの$request）
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreateFolder $request)
    {
        $folder = new Folder();
        $folder->title = $request->title;

        // （ログイン）ユーザーに紐づけて保存する
        /** @var App\Models\User **/
        $user = Auth::user();
        $user->folders()->save($folder);

        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    /**
     * リクエストのnameなどの属性名を再定義するメソッド
     *
     * @return array<string>
     */
    public function attributes()
    {
        return [
            'title' => 'フォルダ名',
        ];
    }

    /**
     *  【フォルダ編集ページの表示機能】
     *
     *  GET /folders/{id}/edit
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        // フォルダが存在するかどうかと、ユーザーがそのフォルダの所有者であるかを確認する
        $folder = $user->folders()->findOrFail($folder->id);

        return view('folders/edit', [
            'folder_id' => $folder->id,
            'folder_title' => $folder->title,
        ]);
    }

    /**
     *  【フォルダの編集機能】
     *
     *  POST /folders/{id}/edit
     *  @param Folder $folder
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, EditFolder $request)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($folder->id);

        $folder->title = $request->title;
        $folder->save();

        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    /**
     *  【フォルダ削除ページの表示機能】
     *  機能：フォルダIDをフォルダ編集ページに渡して表示する
     *
     *  GET /folders/{id}/delete
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */
    public function showDeleteForm(Folder $folder)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($folder->id);

        return view('folders/delete', [
            'folder_id' => $folder->id,
            'folder_title' => $folder->title,
        ]);
    }

    /**
     *  【フォルダの削除機能】
     *  機能：フォルダが削除されたらDBから削除し、フォルダ一覧にリダイレクトする
     *
     *  POST /folders/{id}/delete
     *  @param Folder $folder
     *  @return RedirectResponse
     */
    public function delete(Folder $folder)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($folder->id);

        // フォルダデータ内のタスクを削除
        $folder->tasks()->delete();
        $folder->delete();

        // フォルダの最初のIDを取得（削除してIDの入れ替わりが発生するため）
        $folder = Folder::first();

        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
}
