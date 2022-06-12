<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BatchController;
use App\Http\Controllers\FineController;

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('sign-in', [AuthController::class, 'signin']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);


    // BATCHES
    Route::post('/batch', [BatchController::class, 'store']);
    Route::get('/all', [BatchController::class, 'index']);
    Route::get('/all-batch', [BatchController::class, 'allBatch']);
    Route::put('/batch/update', [BatchController::class, 'update']);
    Route::delete('/batch/delete', [BatchController::class, 'destroy']);

    // FINES
    Route::post('/store-fines', [FineController::class, 'store']);
    Route::GET('/batch-fine', [FineController::class, 'batchesFine']);
    Route::GET('/batch/fine/info', [FineController::class, 'batchWiseFine']);
    Route::post('/student-fine', [FineController::class, 'studentFine']);
    Route::PUT('/student-fine/update', [FineController::class, 'fineUpdate']);
});
