<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\{
    HomeController,
    CategoryController,
    CourseController
};

Route::middleware( 'auth' )
    ->group( function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::get('/courses/{id}/restore', [CourseController::class, 'restore'])->name('courses.restore');
        Route::resources( [
            'categories' => CategoryController::class,
            'courses' => CourseController::class,
        ] );
    } );