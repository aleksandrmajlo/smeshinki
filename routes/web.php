<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use \App\Services\TelegramService;





//use Illuminate\Support\Facades\Artisan;
//Artisan::call('cache:clear');
//Artisan::call('route:clear');
//Artisan::call('config:clear');
//Artisan::call('view:clear');

// главная
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
// страница клиента
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

// календарь общтй
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');
//даты календаря
Route::get('/calendar/{calendar:slug}', [App\Http\Controllers\CalendarController::class, 'show']);
// праздники
Route::get('/holiday/{holiday:slug}', [App\Http\Controllers\HolidayController::class, 'show']);
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
        // фото есть !!!!
        if ($response->channel_post && $response->channel_post->photo) {
            TelegramService::createWordWithPhoto($response->channel_post);
        }
        // video есть !!!!
        if ($response->channel_post && $response->channel_post->video) {
            TelegramService::createWordWithVideo($response->channel_post);
        }
        // только текст
        if ($response->channel_post && $response->channel_post->text) {
            TelegramService::createWordWithText($response->channel_post);
        }
        return 'ok';
    }
);

// получаем картинки видео спарсенное -новости
Route::get('/words', [App\Http\Controllers\WordController::class, 'index']);

// получить даты календаря
Route::get('/getCalendar', [App\Http\Controllers\HomeController::class, 'getCalendar']);
// получить записи календаря на сегодня
Route::post('/getPostToday', [App\Http\Controllers\HomeController::class, 'getPostToday']);
Route::get('/getPostToday', [App\Http\Controllers\HomeController::class, 'getPostToday']);
// получить записи для даного праздника
Route::post('/getPost', [App\Http\Controllers\HomeController::class, 'getPost']);
Route::get('/getPost', [App\Http\Controllers\HomeController::class, 'getPost']);

// получить записи на странице  календаря
Route::get('/getPosts', [App\Http\Controllers\PostController::class, 'getPosts']);
// получить пользователя на странице календаря
// и фаворитлы
Route::get('/getUser', [App\Http\Controllers\PostController::class, 'getUser']);

// получить анедоты
Route::get('/anecdotes', [App\Http\Controllers\AnecdoteController::class, 'index'])->name('anecdotes.index');
Route::get('/anecdote/{anecdote:slug}', [App\Http\Controllers\AnecdoteController::class, 'show']);
// получить анедот рандомно
Route::post('/getAnecdote', [App\Http\Controllers\AnecdoteController::class, 'getAnecdote']);



// добавить и удалить из фаворитов,
Route::post('/addFav', [App\Http\Controllers\UserController::class, 'addFav']);
Route::post('/delFav', [App\Http\Controllers\UserController::class, 'delFav']);
//сортировка sort
Route::post('/sort', [App\Http\Controllers\CalendarController::class, 'sort']);
// отпавить сообщение
Route::post('/addWelcome', [App\Http\Controllers\WelcomeController::class, 'addWelcome']);


// парсер с телеги
Route::post('/test', [App\Http\Controllers\WordController::class, 'test']);
// парсер календаря
Route::get('/calendar_parser', [App\Http\Controllers\CalendarController::class, 'calendar_parser_excel']);

Route::get('/anecdotes_parser', [App\Http\Controllers\AnecdoteController::class, 'anecdotes_parser']);
Route::get('/anecdotes_parser_photo', [App\Http\Controllers\AnecdoteController::class, 'anecdotes_parser_photo']);

// рейтинг лайки новый
Route::post('/addRating', [App\Http\Controllers\LikeController::class, 'addRating']);

// подписка subscription
// активация
Route::get('/subscription', [App\Http\Controllers\SubscriptionController::class, 'activation']);
// получение  email
Route::post('/subscription', [App\Http\Controllers\SubscriptionController::class, 'subscription']);
// сама розсылка
Route::get('/subscription_send', [App\Http\Controllers\SubscriptionController::class, 'send']);
// подписка отписка пользователя
Route::post('/user_subs', [App\Http\Controllers\SubscriptionController::class, 'user_subs'])->name('user_subs');

// создание календаря на год
Route::get('/create_csv_calendar',[\App\Http\Controllers\CalendarController::class,'create_csv_calendar']);
// лайки  getLike
// это не работает !!!!!!!!!
//Route::post('/getLike', [App\Http\Controllers\LikeController::class, 'getLike']);
//Route::post('/addLike', [App\Http\Controllers\LikeController::class, 'addLike']);

// добавить рейтинг
// это не работает !!!!!!!!!
//Route::post('/addRating', [App\Http\Controllers\PostController::class, 'addRating']);
//

// Facebook Login URL
Route::prefix('facebook')->name('facebook.')->group( function(){
    Route::get('auth', [App\Http\Controllers\FaceBookController::class, 'loginUsingFacebook'])->name('login');
    Route::get('callback', [App\Http\Controllers\FaceBookController::class, 'callbackFromFacebook'])->name('callback');
});

// Login telegram
Route::prefix('telegram')->name('telegram.')->group( function(){
    Route::get('redirect', [App\Http\Controllers\TelegramController::class, 'redirect'])->name('redirect');
    Route::get('callback', [App\Http\Controllers\TelegramController::class, 'callbackFromTelegram'])->name('callback');
//    Route::post('callback', [App\Http\Controllers\TelegramController::class, 'callbackFromTelegram'])->name('callback');
});
// Login telegram
Route::prefix('google')->name('google.')->group( function(){
    Route::get('redirect', [App\Http\Controllers\GoogleController::class, 'redirect'])->name('redirect');
    Route::get('callback', [App\Http\Controllers\GoogleController::class, 'callback'])->name('callback');
});

//твиттер медиа крон
Route::get('twitter_media', [App\Http\Controllers\TwitterController::class, 'export']);


Auth::routes();


