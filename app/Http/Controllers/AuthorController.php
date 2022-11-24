<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    private $messages = [
        'full_name.required' => 'Поле имя не должнол быть пустым!!!',
        'email.required' => 'Поле почта не должнол быть пустым!!!',
        'email.email' => 'Поле почта должно содержать адрес почты!!!',
        'avatar.required' => 'Поле аватар не должнол быть пустым!!!',
    ];

    private $rules = [
        "full_name" => "required",
        "email" => "required|email",
        "avatar" => "required"
    ];

    public function all()
    {
        return Author::all('full_name');
    }
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $author = new Author;
            $author->full_name = $request->full_name;
            $author->email = $request->email;
            $author->avatar = $request->avatar;
            $result = $author->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $author = Author::find($request->id);
            if (!$author) {
                return ['Нет такого id'];
            }
            $author->full_name = $request->full_name;
            $author->email = $request->email;
            $author->avatar = $request->avatar;
            $result = $author->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }

    public function search($name)
    {
        return Author::where('full_name', 'like', "%$name%")->get();
    }

    public function delete($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return ["Запись" => "$id не существует"];
        } else {
            $result = $author->delete();
            if ($result) {
                return ["Запись была удалена" => "$id"];
            }
        }
    }
}
