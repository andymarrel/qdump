<?php

/*
 * Test
 */
Route::get('/test', 'TestController@indexAction');

/*
 * Home
 */
Route::get('/', 'HomeController@indexAction');
Route::get('/home', 'HomeController@indexAction');

/*
 * Authorization
 */
Route::get('/auth', ['before' => 'guest', 'uses' => 'AuthController@indexAction']);
Route::post('/login', ['before' => 'guest', 'uses' => 'AuthController@postLoginAction']);
Route::get('/register', ['before' => 'guest', 'uses' => 'AuthController@registerAction']);
Route::post('/register', ['before' => 'guest', 'uses' => 'AuthController@postRegisterAction']);
Route::get('/social/{provider}', 'AuthController@socialAuthAction');
Route::get('/recovery', ['before' => 'guest', 'uses' => 'AuthController@passwordRecoveryAction']);
Route::post('/recovery/post', ['before' => 'csrf|guest', 'uses' => 'AuthController@postRecoveryAction']);
Route::get('/recovery/reset/{userId}/{code}', ['before' => 'guest', 'uses' => 'AuthController@postRecoveryResetAction']);
Route::get('/captcha/refresh', 'AuthController@captchaRefreshAction');
Route::get('/logout', ['before' => 'auth', 'uses' => 'AuthController@logoutAction']);
Route::get('/activate/{userId}/{code}', 'AuthController@activateAction');

/*
 * Settings
 */
Route::get('/settings', ['before' => 'auth', 'uses' => 'SettingsController@indexAction']);
Route::get('/settings/accounts', ['before' => 'auth', 'uses' => 'SettingsController@accountsAction']);
Route::get('/settings/unlink/{provider}', ['before' => 'auth', 'uses' => 'SettingsController@unlinkAction']);