<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ScheduledPaymentController;

    Route::post('/memos',[MemoController::class,'store']);
// /memosという受付先でpost通信を受け取る。MemoControllerを使ってその中のstore()を実行する//
    Route::get('/memos',[MemoController::class,'index']);
    Route::delete('/memos/{id}',[MemoController::class,'delete']);
    Route::post('/transactions',[TransactionController::class,'store']);
    Route::get('/transactions',[TransactionController::class,'index']);
    Route::delete('/transactions/{id}',[TransactionController::class,'delete']);
    Route::post('/transactions/schedule',[ScheduledPaymentController::class,'store']);
    Route::get('/transactions/schedule',[ScheduledPaymentController::class,'index']);
