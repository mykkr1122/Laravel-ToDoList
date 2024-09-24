<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class HomeController extends Controller
{
    /**
     * ホームページを表示する
     *
     * GET /
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var App\Models\User **/
        $user = Auth::user();

        $folder = $user->folders()->first();

        if (is_null($folder)) {
            return view('home');
        }

        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
}
