<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    /**
     *  【タスク一覧ページの表示機能】
     *
     *  GET /folders/{id}/tasks
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */
    public function  index(Folder $folder)
    {
        /** @var App\Models\User **/
        $user = auth()->user();
        $folders = $user->folders()->get();
        $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'folder_id' => $folder->id,
            'tasks' => $tasks
        ]);
    }

    /**
     *  【タスク作成ページの表示機能】
     *  
     *  GET /folders/{id}/tasks/create
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */
    public function showCreateForm(Folder $folder)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($folder->id);
        return view('tasks/create', [
            'folder_id' => $folder->id,
        ]);
    }

    /**
     *  【タスクの作成機能】
     *
     *  POST /folders/{id}/tasks/create
     *  @param Folder $folder
     *  @param CreateTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function create(Folder $folder, CreateTask $request)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($folder->id);


        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $folder->tasks()->save($task);

        /* タスク一覧ページにリダイレクトする */
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    /**
     *  【タスク編集ページの表示機能】
     *  機能：タスクIDをフォルダ編集ページに渡して表示する
     *  ルートモデルバインディングを使用しているため、IDではなくmodelそのものを引数で受け取っている
     *  
     *  GET /folders/{id}/tasks/{task_id}/edit
     *  @param Folder $folder
     *  @param Task $task
     *  @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder, Task $task)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($folder->id);

        return view('tasks/edit', [
            'folder' => $folder,
            'task' => $task,

        ]);
    }

    /**
     *  【タスクの編集機能】
     *  機能：タスクが編集されたらDBを更新処理をしてタスク一覧にリダイレクトする
     *  
     *  POST /folders/{id}/tasks/{task_id}/update
     *  @param Folder $folder
     *  @param Task $task
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function edit(EditTask $request, Folder $folder, Task $task)
    {
        /** @var App\Models\User **/
        // $user = Auth::user();
        // $folder = $user->folders()->findOrFail($folder->id);
        // $task = $folder->tasks()->findOrFail($task->id);


        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    /**
     *  【タスク削除ページの表示機能】
     *  機能：タスクIDをフォルダ削除ページに渡して表示する
     *  
     *  GET /folders/{id}/tasks/{task_id}/delete
     *  @param Folder $folder
     *  @param Task $task
     *  @return \Illuminate\View\View
     */
    public function showDeleteForm(Folder $folder, Task $task)
    {
        /** @var App\Models\User **/
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($folder->id);
        // $task = $folder->find($task->id);

        return view('tasks/delete', [
            'task' => $task,
        ]);
    }

    /**
     *  【タスクの削除機能】
     *
     *  POST /folders/{id}/tasks/{task_id}/delete
     *  @param Folder $folder
     *  @param Task $task
     *  @return \Illuminate\View\View
     */
    public function delete(Folder $folder, Task $task)
    {
        /** @var App\Models\User **/
        // $user = Auth::user();
        // $folder = $user->folders()->findOrFail($folder->id);
        // $task = $folder->find($task->id);
        $task->delete();

        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }
}
