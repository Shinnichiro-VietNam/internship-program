<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'OK']);
});

// パブリックルート
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{book}/order-items', [BookController::class, 'orderItems']);

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{order}', [OrderController::class, 'show']);

Route::get('/reports/books-never-sold', [ReportController::class, 'booksNeverSold']);
Route::get('/reports/book-sales', [ReportController::class, 'bookSales']);
Route::get('/reports/customers-by-city', [ReportController::class, 'customersByCity']);

// 認証が必要なルート
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);

    // 本の書き込み操作保護
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::patch('/books/{book}', [BookController::class, 'update']);

    // 削除操作のみ Gate (manage-books) で認可
    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->middleware('can:manage-books');
});
