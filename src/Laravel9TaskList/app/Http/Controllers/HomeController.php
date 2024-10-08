<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        try {
            /** @var App\Models\User **/
            $user = Auth::user();

            $folder = $user->folders()->first();

            if (is_null($folder)) {
                return view('home');
            }

            return redirect()->route('tasks.index', [
                'folder' => $folder->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error HomeController in index: ' . $e->getMessage());
        }
    }
}
