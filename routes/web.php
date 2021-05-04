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
Route::get('/test1', function(){
    return view('admin.request.create_new');
});
Route::get('/dang-ky-thi-chung-chi/{id}', 'Client\ClientController@certificateForm')->name('certificate-form');
Route::post('/dang-ky-thi-chung-chi/{id}', 'Client\ClientController@addCertificate')->name('certificate-form-post');

Route::get('/', function () {
    return redirect()->route('admin.index');
})->name('index');

Route::group([], function () {
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload')->name('unisharp.lfm.upload');
    // list all lfm routes here...
});



/**
 * Toàn bộ Controller trong này, phải thuộc namespace Admin
 * Nên cái controller ContactFormController kia của anh không tồn tại là đúng rồi
 * Vì nó không thuộc namepsace Admin
 * 
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['web', 'auth'], 'as' => 'admin.'], function() {
    require __DIR__ . '/admin/index.php';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'TestController@index')->name('test');

Route::any('/captcha.php', 'HomeController@createCaptcha');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['prefix' => 'cronjob'], function(){
    Route::get('/send-mail-auto', 'Client\ClientController@autoSendMail');
});