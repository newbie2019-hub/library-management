<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IssuedBookController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    //Authenticated User
    Route::get('/user', fn() => response()->success(auth()->user()));

    Route::apiResources([
        'books' => BookController::class,
        'authors' => AuthorController::class,
        'category' => CategoryController::class,
        'issue-book' => IssuedBookController::class
    ]);
});
