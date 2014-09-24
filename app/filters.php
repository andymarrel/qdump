<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (!Sentry::check()){
        return Redirect::to('/')->with('notification', [
            'type' => 'error',
            'message' => 'Необходимо войти в систему'
        ]);
    }
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Sentry::check()){
        return Redirect::to('/')->with('notification', [
            'type' => 'error',
            'message' => 'Необходимо выйти из системы'
        ]);
    }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
    $token = Request::ajax() ? Request::header('x-csrf-token') : Input::get('_token');

	if (Session::token() != $token)
	{
		//throw new Illuminate\Session\TokenMismatchException;
        if (Request::ajax()){
            return Response::json([
                'result' => false,
                'errors' => [
                    'csrf' => 'Ошибка безопасности: неверный код безопасности'
                ]
            ]);
        } else {
            return Redirect::to('/')->with('notification', [
                'type' => 'error',
                'message' => 'Ошибка безопасности: неверный код безопасности'
            ]);
        }
	}
});


App::missing(function($exception)
{
    return Response::view('errors.404', array(), 404);
});