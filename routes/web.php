<?php

use Illuminate\Support\Facades\Route;

// главная
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
// страница клиента
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
// календарь общтй
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');
// лог
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
/*
 *  телеграм хук
 */
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

// получить даты календаря
Route::get('/getCalendar', [App\Http\Controllers\HomeController::class, 'getCalendar']);
// получить записи для даного праздника
Route::post('/getPost', [App\Http\Controllers\HomeController::class, 'getPost']);
// получить анедот
Route::post('/getAnecdote', [App\Http\Controllers\HomeController::class, 'getAnecdote']);
// получаем картинки
Route::get('/getWord', [App\Http\Controllers\HomeController::class, 'getWord']);
//даты календаря
Route::get('/calendar/{calendar:slug}', [App\Http\Controllers\CalendarController::class,'show']);

// добавить и удалить из фаворитов,
Route::post('/addFav', [App\Http\Controllers\UserController::class, 'addFav']);
Route::post('/delFav', [App\Http\Controllers\UserController::class, 'delFav']);
// добавить рейтинг
Route::post('/addRating', [App\Http\Controllers\PostController::class, 'addRating']);
//сортировка sort
Route::post('/sort', [App\Http\Controllers\CalendarController::class, 'sort']);
// отпавить сообщение
Route::post('/addWelcome', [App\Http\Controllers\WelcomeController::class, 'addWelcome']);

Auth::routes();

