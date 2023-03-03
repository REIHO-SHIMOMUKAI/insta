<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware'=>'auth'],function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/suggested-users',[HomeController::class, 'suggestedUsers'])->name('suggested-users');

    Route::get('post/create',[PostController::class,'create'])->name('post.create');
    
    Route::post('post/store',[PostController::class,'store'])->name('post.store');
    
    Route::get('post/{id}/show',[PostController::class,'show'])->name('post.show');

    Route::get('post/{id}/edit',[PostController::class,'edit'])->name('post.edit');

    Route::patch('/post/{id}/update',
    [PostController::class, 'update'])->name('post.update');

    Route::delete('/post/{id}/delete',
    [PostController::class, 'delete'])->name('post.delete');

    Route::post('/comment/{post_id}/store',
    [CommentController::class,'store'])->name('comment.store');

    Route::delete('/comment/{id}/delete',[CommentController::class,'delete'])->name('comment.delete');

    Route::get('/profile/{id}/show',[ProfileController::class, 'show'])->name('profile.show');

    Route::get('/profile/{id}/followers',[ProfileController::class, 'followers'])->name('profile.followers');

    Route::get('/profile/{id}/following',[ProfileController::class, 'following'])->name('profile.following');

    Route::get('/profile/edit',[ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile/update',[ProfileController::class, 'update'])->name('profile.update');

    Route::patch('/profile/change-password',[ProfileController::class, 'changePassword'])->name('profile.change-password');

    Route::post('/like/{post_id}/store',[LikeController::class, 'store'])->name('like.store');

    Route::delete('/like/{post_id}/delete',[LikeController::class, 'delete'])->name('like.delete');

    Route::post('/follow/{uid}/store',[FollowController::class, 'store'])->name('follow.store');

    Route::delete('/follow/{uid}/delete',[FollowController::class, 'delete'])->name('follow.delete');


    // admin routes
    // adminだけ行けるページ
    //can: apply Gate(Providers\AppServiceProvider.phpで使っている)
    Route::group(['middleware'=>'can:admin'],function(){
        Route::get('/admin/users',[UsersController::class, 'index'])->name('admin.users');

        Route::delete('/admin/users/{id}/deactivate',[UsersController::class, 'deactivate'])->name('admin.users.deactivate');
    
        Route::patch('/admin/users/{id}/activate',[UsersController::class, 'activate'])->name('admin.users.activate');
    
        Route::get('/admin/posts',[PostsController::class, 'index'])->name('admin.posts');
    
        Route::delete('/admin/posts/{id}/hide',[PostsController::class, 'hide'])->name('admin.posts.hide');
    
        Route::patch('/admin/posts/{id}/unhide',[PostsController::class, 'unhide'])->name('admin.posts.unhide');
    
        Route::get('/admin/categories',[CategoriesController::class, 'index'])->name('admin.categories');
    
        Route::patch('/admin/categories/create',[CategoriesController::class, 'create'])->name('admin.categories.create');
    
        Route::delete('/admin/categories/{id}/delete',[CategoriesController::class, 'delete'])->name('admin.categories.delete');
    
        Route::patch('/admin/categories/{id}/update',[CategoriesController::class, 'update'])->name('admin.categories.update');
    
    });
});
    


