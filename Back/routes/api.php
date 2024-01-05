<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('addUser', [UserController::class, 'create']);

Route::get('allUsers', [UserController::class, 'index']);

Route::post('updateUser/{userId}', [UserController::class, 'update']);

Route::post('login', [UserController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group( function () {

    Route::post('logout', [UserController::class, 'logout']);

    Route::delete('delete/{id}', [UserController::class, 'destroy']);

    Route::prefix('task')->group(function (){
        Route::post('create/{idUser}',[TaskController::class,'store']);
        Route::get('list/{idUser}',[TaskController::class,'index']);
        Route::post('search/{idUser}',[TaskController::class,'searchTask']);
        Route::post('update/{idUser}',[TaskController::class,'update']);
        Route::delete('delete/{idUser}/{idTask}',[TaskController::class,'destroy']);

    });

});


