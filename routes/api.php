<?php

// use App\Http\Controllers\Api\Articles\ArticleController;
// use App\Http\Controllers\Api\Articles\CommentsController;
// use App\Http\Controllers\Api\Articles\FavoritesController;
// use App\Http\Controllers\Api\ProfileController;
// use App\Http\Controllers\Api\TagsController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\FixcontentController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReadUrlController;
use App\Http\Controllers\UserController;
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

Route::name('api.')->group(function () {
    Route::get('menu', [MenuController::class, 'index'])->name('index');
    Route::post('menu', [MenuController::class, 'getMenus'])->name('getMenus');

    Route::post('read_url', [ReadUrlController::class, 'read_url']);
    Route::get('read_url_article', [ReadUrlController::class, 'read_url_article']);

    Route::prefix('menu/element')->group(function () {
        Route::get('/', 'MenuElementController@index')->name('menu.index');
        Route::get('/move-up', 'MenuElementController@moveUp')->name('menu.up');
        Route::get('/move-down', 'MenuElementController@moveDown')->name('menu.down');
        Route::get('/create', 'MenuElementController@create')->name('menu.create');
        Route::post('/store', 'MenuElementController@store')->name('menu.store');
        Route::get('/get-parents', 'MenuElementController@getParents');
        Route::get('/edit', 'MenuElementController@edit')->name('menu.edit');
        Route::post('/update', 'MenuElementController@update')->name('menu.update');
        Route::get('/show', 'MenuElementController@show')->name('menu.show');
        Route::get('/delete', 'MenuElementController@delete')->name('menu.delete');
    });

    Route::name('users.')->group(function () {
        Route::middleware('auth.admin')->group(function () {
            Route::get('user', [UserController::class, 'show'])->name('current');
            Route::put('user', [UserController::class, 'update'])->name('update');
        });

        Route::post('users/login', [AuthController::class, 'login'])->name('login');
        Route::post('users', [AuthController::class, 'register'])->name('register');
    });

    Route::name('fixcontent.')->group(function () {
        //Route::middleware('auth.admin')->group(function () {
        Route::prefix('fixcontent')->group(function () {
            Route::post('/generate', [FixcontentController::class, 'generate_content'])->name('fixcontent.generate_content');
            Route::post('/newword', [FixcontentController::class, 'addNewWord'])->name('fixcontent.addNewWord');

            // Route::get('/', [FixcontentController::class, 'index'])->name('fixcontent.index');
            // Route::get('/feed', [FixcontentController::class, 'list'])->name('fixcontent.list');
            // Route::post('/', [FixcontentController::class, 'store'])->name('fixcontent.store');
            // Route::post('articles', [ArticleController::class, 'create'])->name('create');
            // Route::put('articles/{slug}', [ArticleController::class, 'update'])->name('update');
            // Route::delete('articles/{slug}', [ArticleController::class, 'delete'])->name('delete');
        });
        //});
    });

    Route::name('facebook.')->group(function () {
        Route::middleware('auth.admin')->group(function () {
            Route::prefix('facebook')->group(function () {
                Route::post('/addword', [FacebookController::class, 'add_word'])->name('facebook.addword');
                Route::get('/listword', [FacebookController::class, 'list_word'])->name('facebook.listword');
                // Route::post('articles', [ArticleController::class, 'create'])->name('create');
                // Route::put('articles/{slug}', [ArticleController::class, 'update'])->name('update');
                // Route::delete('articles/{slug}', [ArticleController::class, 'delete'])->name('delete');
            });
        });
    });

    // Route::name('profiles.')->group(function () {
    //     Route::middleware('auth:api')->group(function () {
    //         Route::post('profiles/{username}/follow', [ProfileController::class, 'follow'])->name('follow');
    //         Route::delete('profiles/{username}/follow', [ProfileController::class, 'unfollow'])->name('unfollow');
    //     });

    //     Route::get('profiles/{username}', [ProfileController::class, 'show'])->name('get');
    // });

    // Route::name('articles.')->group(function () {
    //     Route::middleware('auth:api')->group(function () {
    //         Route::get('articles/feed', [ArticleController::class, 'feed'])->name('feed');
    //         Route::post('articles', [ArticleController::class, 'create'])->name('create');
    //         Route::put('articles/{slug}', [ArticleController::class, 'update'])->name('update');
    //         Route::delete('articles/{slug}', [ArticleController::class, 'delete'])->name('delete');
    //     });

    //     Route::get('articles', [ArticleController::class, 'list'])->name('list');
    //     Route::get('articles/{slug}', [ArticleController::class, 'show'])->name('get');

    //     Route::name('comments.')->group(function () {
    //         Route::middleware('auth:api')->group(function () {
    //             Route::post('articles/{slug}/comments', [CommentsController::class, 'create'])->name('create');
    //             Route::delete('articles/{slug}/comments/{id}', [CommentsController::class, 'delete'])->name('delete');
    //         });

    //         Route::get('articles/{slug}/comments', [CommentsController::class, 'list'])->name('get');
    //     });

    //     Route::name('favorites.')->group(function () {
    //         Route::middleware('auth:api')->group(function () {
    //             Route::post('articles/{slug}/favorite', [FavoritesController::class, 'add'])->name('add');
    //             Route::delete('articles/{slug}/favorite', [FavoritesController::class, 'remove'])->name('remove');
    //         });
    //     });
    // });

    // Route::name('tags.')->group(function () {
    //     Route::get('tags', [TagsController::class, 'list'])->name('list');
    // });
});
