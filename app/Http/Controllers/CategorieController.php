<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    private $messages = [
        'name.required' => 'Поле имя не должнол быть пустым!!!',
        'parent_id.required' => 'Поле id родительской рубрики не должнол быть пустым!!!',
        'parent_id.numeric' => 'Поле id родительской рубрики должно содержать id(цифру)!!!',
    ];
    private $rules = [
        "name" => "required",
        "parent_id" => "required|numeric",
    ];
    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $categorie = new Categorie;
            $categorie->name = $request->name;
            $categorie->parent_id = $request->parent_id;
            $result = $categorie->save();
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
            $categorie = Categorie::find($request->id);
            if (!$categorie) {
                return ['Нет такого id'];
            }
            $categorie->name = $request->name;
            $categorie->parent_id = $request->parent_id;
            $result = $categorie->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }
}
