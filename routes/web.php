<?php

use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SensorController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "/home");
Route::resource('/home', HomeController::class)->only(['index']);

Route::get('/equipamentos', [EquipamentoController::class, 'index']);
Route::post('/equipamentos/{id}/turnOn', [EquipamentoController::class, 'turnOn']);
Route::post('/equipamentos/{id}/turnOff', [EquipamentoController::class, 'turnOff']);
Route::post('/equipamentos', [EquipamentoController::class, 'store']);
Route::get('/sensores/update', [SensorController::class, 'update']);
