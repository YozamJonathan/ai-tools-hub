<?php
// ============================================================
// FILE: routes/web.php  (REPLACE the entire file)
// ============================================================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminToolController;
use App\Http\Controllers\Admin\AdminSuggestionController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminReviewController;

// ── Public Routes ─────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tools/{tool}', [ToolController::class, 'show'])->name('tools.show');

// ── Authenticated User Routes ─────────────────────────────

Route::middleware('auth')->group(function () {
    Route::get('/library', function () {
    return view('library');
})->name('library');


    // Favorites / Collections
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/toggle/{tool}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::post('/collections', [FavoriteController::class, 'store'])->name('collections.store');

    // Reviews
    Route::post('/tools/{tool}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Ratings & Upvotes (AJAX)
    Route::post('/tools/{tool}/rate', [ToolController::class, 'rate'])->name('tools.rate');
    Route::post('/tools/{tool}/upvote', [ToolController::class, 'upvote'])->name('tools.upvote');

    // Suggestions
    Route::get('/suggest', [SuggestionController::class, 'index'])->name('suggest');
    Route::post('/suggest', [SuggestionController::class, 'store'])->name('suggest.store');

    // Messages (Ask Yozee)
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});

// ── Admin Routes ──────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Tools CRUD
    Route::get('/tools', [AdminToolController::class, 'index'])->name('tools.index');
    Route::get('/tools/create', [AdminToolController::class, 'create'])->name('tools.create');
    Route::post('/tools', [AdminToolController::class, 'store'])->name('tools.store');
    Route::get('/tools/{tool}/edit', [AdminToolController::class, 'edit'])->name('tools.edit');
    Route::put('/tools/{tool}', [AdminToolController::class, 'update'])->name('tools.update');
    Route::delete('/tools/{tool}', [AdminToolController::class, 'destroy'])->name('tools.destroy');

    // Suggestions
    Route::get('/suggestions', [AdminSuggestionController::class, 'index'])->name('suggestions.index');
    Route::post('/suggestions/{suggestion}/approve', [AdminSuggestionController::class, 'approve'])->name('suggestions.approve');
    Route::post('/suggestions/{suggestion}/reject', [AdminSuggestionController::class, 'reject'])->name('suggestions.reject');

    // Messages
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{message}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');

    // Reviews
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
});

// Laravel Breeze auth routes (login, register, logout)
require __DIR__.'/auth.php';