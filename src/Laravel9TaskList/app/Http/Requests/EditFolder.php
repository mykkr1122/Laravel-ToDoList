<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CreateFolderクラスを継承しており、
 * EditFolderクラスでもCreateFolderクラスのバリデーションが適用される。
 * 同じバリデーションルールを適用する際は、継承した先のクラスには何も書かない。
 */
class EditFolder extends CreateFolder {

}
