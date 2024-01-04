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

// Route::post('task/create/{idUser}', [TaskController::class,'store']);


Route::prefix('task')->group(function (){
    Route::post('create/{idUser}',[TaskController::class,'store']);
});


