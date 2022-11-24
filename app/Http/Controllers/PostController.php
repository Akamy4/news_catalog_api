<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    private $messages = [
        'header.required' => 'Поле заголовок не должнол быть пустым!!!',
        'announcement.required' => 'Поле анонс не должнол быть пустым!!!',
        'text.required' => 'Поле текст должно содержать адрес почты!!!',
        'publication_date.required' => 'Поле дата публикации не должнол быть пустым!!!',
        'author_id.required' => 'Поле id автора не должнол быть пустым!!!',
        'announcement.date' => 'Поле дата анонса должнол быть в формате даты!!!',
        'publication_date.date' => 'Поле дата публицакции должнол быть в формате даты!!!',
        'author_id.numeric' => 'Поле id автора должно содержать id(цифру)!!!',
    ];
    private $rules = [
        "header" => "required",
        "announcement" => "required|date",
        "text" => "required",
        "publication_date" => "required|date",
        "author_id" => "required|numeric",
    ];
    public function by_author_id($id)
    {
        $posts = Post::select('id', 'header', 'announcement', 'text', 'publication_date')->where('author_id', $id)->get();
        return $posts;
    }
    public function by_categorie_id($id)
    {
        $posts = Post::select('posts.header')
            ->join('post_categories', 'posts.id', '=', 'post_categories.post_id')
            ->join('categories', 'post_categories.categorie_id', '=', 'categories.id')
            ->where('post_categories.categorie_id', '=', $id)->get();
        return $posts;
    }
    public function by_id($id)
    {
        $posts = Post::select('id', 'header', 'announcement', 'text', 'publication_date')->where('id', $id)->get();
        return $posts;
    }

    public function by_name($name)
    {
        $posts = Post::select('id', 'header', 'announcement', 'text', 'publication_date')->where('header', 'like', "%$name%")->get();
        return $posts;
    }

    public function by_categories_id($id)
    {
        $posts = array();
        $arr = explode(',', $id);
        foreach ($arr  as $elem) {
            $posts[] = Post::select('posts.header')
                ->join('post_categories', 'posts.id', '=', 'post_categories.post_id')
                ->join('categories', 'post_categories.categorie_id', '=', 'categories.id')
                ->where('post_categories.categorie_id', '=', $elem)->get();
        }
        $posts = array_unique($posts);
        return $posts;
    }
    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $post = new Post;
            $post->header = $request->header;
            $post->announcement = $request->announcement;
            $post->text = $request->text;
            $post->publication_date = $request->publication_date;
            $post->author_id = $request->author_id;
            $result = $post->save();
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
            $post = Post::find($request->id);
            if (!$post) {
                return ['Нет такого id'];
            }
            $post->header = $request->header;
            $post->announcement = $request->announcement;
            $post->text = $request->text;
            $post->publication_date = $request->publication_date;
            $post->author_id = $request->author_id;
            $result = $post->save();
            if ($result) {
                return ['Success'];
            } else {
                return ['Error'];
            }
        }
    }
}