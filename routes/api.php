<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategorieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("/all_authors", [AuthorController::class, 'all']);
Route::get("/by_author_id/{id?}", [PostController::class, 'by_author_id']);
Route::get("/by_categorie_id/{id?}", [PostController::class, 'by_categorie_id']);
Route::get("/by_post_id/{id?}", [PostController::class, 'by_id']);
Route::get("/by_post_name/{name?}", [PostController::class, 'by_name']);
Route::get("/by_categories_id/{id?}", [PostController::class, 'by_categories_id']);
Route::get("/author_search/{name?}", [AuthorController::class, 'search']);

Route::post("/author_add", [AuthorController::class, 'add']);
Route::post("/post_add", [PostController::class, 'add']);
Route::post("/categories_add", [CategorieController::class, 'add']);

Route::put("/author_update", [AuthorController::class, 'update']);
Route::put("/post_update", [PostController::class, 'update']);
Route::put("/categorie_update", [CategorieController::class, 'update']);

Route::delete("/author_delete/{id?}", [AuthorController::class, 'delete']);