<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\GalleryController as PublicGalleryController;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('HomePage');
});

Route::get('/contact', function () {
    return Inertia::render('ContactPage');
});

Route::get('/visi-misi', function () {
    return Inertia::render('VisiMisiPage');
});

Route::get('/kurikulum', function () {
    return Inertia::render('KurikulumPage');
});

Route::get('/struktur', function () {
    return Inertia::render('StrukturPage');
});

Route::get('/produk', [PublicProductController::class, 'index']);

Route::get('/gallery', [PublicGalleryController::class, 'index']);

Route::get('/news', [PublicNewsController::class, 'index']);
Route::get('/news/{news}', [PublicNewsController::class, 'show'])->name('news.show');

Route::get('/ecard', function () {
    return Inertia::render('EcardPage');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->group(function () {
        Route::resource('products', ProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'show' => 'admin.products.show',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);

        Route::delete('/product-images/{image}', [ProductController::class, 'destroyImage'])->name('admin.product-images.destroy');

        Route::resource('news', NewsController::class)->names([
            'index' => 'admin.news.index',
            'create' => 'admin.news.create',
            'store' => 'admin.news.store',
            'show' => 'admin.news.show',
            'edit' => 'admin.news.edit',
            'update' => 'admin.news.update',
            'destroy' => 'admin.news.destroy',
        ]);
        
        Route::post('/news/upload-image', [NewsController::class, 'uploadImage'])->name('admin.news.uploadImage');

        // Gallery Routes
        Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
        Route::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
        Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

        // User Route
        Route::resource('users', UserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
    });
});