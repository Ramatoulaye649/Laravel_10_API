<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//Recuperer la liste des postes
Route::get('posts',[PostController::class, 'index']);

//Ajouter une poste



Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::middleware('auth:sanctum')->group(function(){
    //retourner utilisateur actuellement connecté
    Route::delete('posts/{post}',[PostController::class,'delete']);
    Route::put('posts/edit/{post}',[PostController::class,'update']);
    Route::post('posts/create',[PostController::class, 'store']);
    Route::get('/user',function(Request $request){
        return $request->user();
    });
});
