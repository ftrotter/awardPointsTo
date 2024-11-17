<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseTeamController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\PointTransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {
    // HouseTeams
    Route::apiResource('house-teams', HouseTeamController::class);
    Route::get('house-teams/{id}/team-members', [HouseTeamController::class, 'teamMembers']);

    // TeamMembers
    Route::apiResource('team-members', TeamMemberController::class);
    Route::get('team-members/{id}/house-teams', [TeamMemberController::class, 'houseTeams']);

    // Point Transactions
    Route::post('points', [PointTransactionController::class, 'store']);
});

