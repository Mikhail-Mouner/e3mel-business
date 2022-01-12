<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    CategoryController,
    CourseController,
    UserAuthController
};

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
Route::prefix( 'v1' )
    ->group( function () {

        Route::post( 'register', [ UserAuthController::class, 'register' ] );
        Route::post( 'login', [ UserAuthController::class, 'login' ] );

        Route::get( '/categories/list', [ CategoryController::class, 'list' ] )->name( 'categories.list' );
        Route::get( '/courses/list', [ CourseController::class, 'list' ] )->name( 'courses.list' );

        Route::middleware( 'auth:api' )
            ->group( function () {
                Route::get( '/categories', [ CategoryController::class, 'index' ] );
                Route::get( '/courses', [ CourseController::class, 'index' ] );
                Route::get( 'user', [ UserAuthController::class, 'me' ] );
            } );
    } );
