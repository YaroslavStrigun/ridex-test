<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::match(['get', 'post'], 'register', function () {
    Auth::logout();
    return redirect('/');
})->name('register');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {
   $lessons = \App\Models\Schedule::byWeek()->groupBy('day');

   $response = "1 неделя" . ":\r\n";
    foreach ($lessons as $day_number => $day_lessons) {
        $response .= \App\Helpers\DateHelper::MAP_WEEK_DAYS_NAME[$day_number] . ":\r\n";
        foreach ($day_lessons->sortBy('start') as $lesson) {
            $response .= sprintf('%s (%s - %s)' . PHP_EOL, $lesson->lesson, $lesson->start, $lesson->end);
        }
    }
   dd($response);
});

Route::post('/656854613:AAHKcubgp0-B-y2H8tPkCobn31cUcxn18LY', 'TelegramController@webhook');

Route::middleware(['auth'])->prefix('admin')->namespace('Backend')->name('admin.')->group(function (){
    Route::get('/', 'DashboardController@index')->name('index');

    Route::get('/setting', 'SettingController@index')->name('setting.index');

    Route::post('/setting/store', 'SettingController@store')->name('setting.store');

    Route::post('setting/setwebhook', 'SettingController@setwebhook')->name('setting.setwebhook');

    Route::post('setting/getwebhookinfo', 'SettingController@getwebhookinfo')->name('setting.getwebhookinfo');
});
