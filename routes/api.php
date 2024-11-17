<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseteamController;
use App\Http\Controllers\HouseteamMemberController;
use App\Http\Controllers\PointTransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Houseteams
    Route::apiResource('houseteams', HouseteamController::class);
    Route::get('houseteams/{id}/houseteam-members', [HouseteamController::class, 'houseteamMembers']);

    // Houseteam Members
    Route::apiResource('houseteam-members', HouseteamMemberController::class);
    Route::get('houseteam-members/{id}/houseteams', [HouseteamMemberController::class, 'houseteams']);

    // Point Transactions
    Route::post('points', [PointTransactionController::class, 'store']);
});
