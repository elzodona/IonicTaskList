<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('addUser', [UserController::class, 'create']);

Route::get('allUsers', [UserController::class, 'index']);

Route::post('updateUser/{userId}', [UserController::class, 'update']);

// Route::post('task/create/{idUser}', [TaskController::class,'store']);


Route::prefix('task')->group(function (){
    Route::post('create/{idUser}',[TaskController::class,'store']);
    Route::get('list/{idUser}',[TaskController::class,'index']);
    Route::get('search/{idUser}',[TaskController::class,'searchTask']);
    Route::post('update/{idUser}',[TaskController::class,'update']);
    Route::delete('delete/{idUser}/{idTask}',[TaskController::class,'destroy']);
});


// Route::middleware('auth:sanctum')->group(function () {
//     Route::prefix('task')->group(function () {
//         Route::post('create/{idUser}', [UserController::class, 'store']);
//     });
// });



Route::post('login', [UserController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('task/{idUser}', [TaskController::class, 'listeTask']);

});

