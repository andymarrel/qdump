<?php

/*
 * Test
 */
Route::get('/test', 'TestController@indexAction');
Route::get('/email', function(){
    Mail::send('emails.registration', [], function($message){
        $message->to('andymarrell@gmail.com')
            ->subject('Complete Qdump registration!');
    });
});

/*
 * Home
 */
Route::get('/', 'HomeController@indexAction');
Route::get('/home', 'HomeController@indexAction');

/*
 * Authorization
 */
Route::get('/auth', 'AuthController@indexAction');
Route::post('/login', 'AuthController@postLoginAction');
Route::get('/register', 'AuthController@registerAction');
Route::post('/register', 'AuthController@postRegisterAction');
Route::get('/social/{provider}', 'AuthController@socialAuthAction');
Route::get('/recovery', 'AuthController@passwordRecoveryAction');
Route::get('/captcha/refresh', 'AuthController@captchaRefreshAction');
Route::get('/logout', 'AuthController@logoutAction');
Route::get('/activate/{userId}/{code}', 'AuthController@activateAction');

/*
 * Settings
 */
Route::get('/settings', 'SettingsController@indexAction');
Route::get('/settings/accounts', 'SettingsController@accountsAction');
Route::get('/settings/unlink/{provider}', 'SettingsController@unlinkAction');