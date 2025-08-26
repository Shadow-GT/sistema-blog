<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTypeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rutas públicas del blog
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/post/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/type/{postType:slug}', [BlogController::class, 'postType'])->name('blog.post-type');

// Rutas para comentarios (accesibles para invitados)
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/request-author', [ProfileController::class, 'requestAuthor'])->name('profile.request-author');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para autores y administradores (pueden publicar)
Route::middleware(['auth', 'can.publish'])->group(function () {
    Route::resource('posts', PostController::class);
    Route::post('posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
});

// Rutas solo para administradores
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Panel de moderación
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::get('/moderation/posts', [ModerationController::class, 'posts'])->name('moderation.posts');
    Route::patch('/moderation/posts/{post}/approve', [ModerationController::class, 'approvePost'])->name('moderation.posts.approve');
    Route::patch('/moderation/posts/{post}/reject', [ModerationController::class, 'rejectPost'])->name('moderation.posts.reject');
    Route::post('/moderation/posts/bulk-approve', [ModerationController::class, 'bulkApprovePosts'])->name('moderation.posts.bulk-approve');

    // Gestión de usuarios (roles)
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('admin.users.update-role');
    Route::patch('/admin/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');

    // Solicitudes de autor
    Route::get('/admin/author-requests', [\App\Http\Controllers\Admin\AuthorRequestController::class, 'index'])->name('admin.author-requests.index');
    Route::patch('/admin/author-requests/{user}/approve', [\App\Http\Controllers\Admin\AuthorRequestController::class, 'approve'])->name('admin.author-requests.approve');
    Route::patch('/admin/author-requests/{user}/reject', [\App\Http\Controllers\Admin\AuthorRequestController::class, 'reject'])->name('admin.author-requests.reject');

    // Configuración del blog
    Route::get('/admin/blog-settings', [\App\Http\Controllers\Admin\BlogSettingsController::class, 'index'])->name('admin.blog-settings.index');
    Route::patch('/admin/blog-settings', [\App\Http\Controllers\Admin\BlogSettingsController::class, 'update'])->name('admin.blog-settings.update');
    Route::delete('/admin/blog-settings/logo', [\App\Http\Controllers\Admin\BlogSettingsController::class, 'removeLogo'])->name('admin.blog-settings.remove-logo');

    // Moderación (alias para admin posts)
    Route::get('/moderation', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('moderation.index');
    Route::get('/admin/posts', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.posts.index');
    Route::patch('/admin/posts/{post}/approve', [\App\Http\Controllers\Admin\PostController::class, 'approve'])->name('admin.posts.approve');
    Route::patch('/admin/posts/{post}/reject', [\App\Http\Controllers\Admin\PostController::class, 'reject'])->name('admin.posts.reject');
    Route::delete('/admin/posts/{post}', [\App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('admin.posts.destroy');

    // Comentarios
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/moderation/posts/bulk-reject', [ModerationController::class, 'bulkRejectPosts'])->name('moderation.posts.bulk-reject');
    Route::post('/moderation/comments/bulk-approve', [ModerationController::class, 'bulkApproveComments'])->name('moderation.comments.bulk-approve');
    Route::post('/moderation/comments/bulk-reject', [ModerationController::class, 'bulkRejectComments'])->name('moderation.comments.bulk-reject');

    // Gestión de categorías
    Route::resource('categories', CategoryController::class);

    // Gestión de tipos de post
    Route::resource('post-types', PostTypeController::class);

    // Gestión de comentarios
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
});

require __DIR__.'/auth.php';
