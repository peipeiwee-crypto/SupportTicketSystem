<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketCommentController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    });

    // Tickets
    Route::get('/tickets/all', [TicketController::class, 'all']); // All tickets for commenting
    Route::apiResource('tickets', TicketController::class);
    
    // Ticket Comments - Anyone can comment on any ticket
    Route::post('/tickets/{ticket}/comments', [TicketCommentController::class, 'store']);
});