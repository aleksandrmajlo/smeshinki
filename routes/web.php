<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use \App\Services\TelegramService;

//use Illuminate\Support\Facades\Artisan;
// Artisan::call('cache:clear');
// Artisan::call('route:clear');
// Artisan::call('config:clear');
// Artisan::call('view:clear');

// главная
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
// страница клиента
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
// календарь общтй
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');
// лог
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
/*
 *  телеграм хук *****************************************************
 */
Route::post(
    '/getWebhookInfo',
    function () {
        $request = file_get_contents("php://input");
        TelegramService::putLogIn($request);
        $response = Telegram::getWebhookUpdates();
//        dd($response);
        // фото есть !!!!
        if($response->channel_post&&$response->channel_post->photo){
            TelegramService::createWordWithPhoto($response->channel_post);
        }
        // video есть !!!!
        if($response->channel_post&&$response->channel_post->video){
            TelegramService::createWordWithVideo($response->channel_post);
        }
        // только текст
        if($response->channel_post&&$response->channel_post->text){
            TelegramService::createWordWithText($response->channel_post);
        }
        return 'ok';
    }
);
// получаем новости
Route::get('get', [\App\Http\Controllers\WordController::class, 'get']);

// получить даты календаря
Route::get('/getCalendar', [App\Http\Controllers\HomeController::class, 'getCalendar']);
// получить записи календаря на сегодня
Route::post('/getPostToday', [App\Http\Controllers\HomeController::class, 'getPostToday']);
// получить записи для даного праздника
Route::post('/getPost', [App\Http\Controllers\HomeController::class, 'getPost']);
// получить записи на странице  календаря
Route::get('/getPosts', [App\Http\Controllers\PostController::class, 'getPosts']);
// получить пользователя на странице календаря
// и фаворитлв
Route::get('/getUser', [App\Http\Controllers\PostController::class, 'getUser']);

// получить анедот
Route::post('/getAnecdote', [App\Http\Controllers\HomeController::class, 'getAnecdote']);

// получаем картинки видео спарсенное
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

