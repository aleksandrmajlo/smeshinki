<?php

use Illuminate\Support\Facades\Route;

Route::post(
    '/getWebhookInfo',
    function () {
        $request = file_get_contents("php://input");
        \App\Services\TelegramService::putLogIn($request);
        return 'ok';
    }
);
// получаем новости
Route::get('get', [\App\Http\Controllers\WordController::class, 'get']);

// лог
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
// главная
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// получить даты календаря
Route::get('/getCalendar', [App\Http\Controllers\HomeController::class, 'getCalendar']);
// получить записи для даного праздника
Route::post('/getPost', [App\Http\Controllers\HomeController::class, 'getPost']);
// получить анедот
Route::post('/getAnecdote', [App\Http\Controllers\HomeController::class, 'getAnecdote']);
// получаем картинки
//Route::post('/getWord', [App\Http\Controllers\HomeController::class, 'getWord']);
Route::get('/getWord', [App\Http\Controllers\HomeController::class, 'getWord']);
//даты календаря
Route::get('/calendar/{calendar:slug}', [App\Http\Controllers\CalendarController::class,'show']);

Auth::routes(['register' => false]);

