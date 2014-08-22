@extends('layout')

@section('ngController')"SettingsController"@stop

@section('content')
    <div class="container">
        @include('navbar', ['active' => 'settings'])
        <div class="col-lg-2">
        </div>
        <div class="col-lg-7">
            @if (!Sentry::getUser()->isSocialAccount())
            <div class="form-group" style="text-align: center;">
                @if (!Sentry::getUser()->hasLinkedAccount('vk'))
                    <a href="{{ Sociauth::getProvider('vk')->getAuthUrl() }}" class="btn" style="width: 300px; background-color: #4C75A3; color: #fff;">Привязать аккаунт Вконтакте</a>
                @else
                    <a href="/settings/unlink/vk" class="btn" style="width: 300px; background-color: indianred; color: #fff;">Отвязать аккаунт Вконтакте</a>
                @endif
            </div>
            <div class="form-group" style="text-align: center;">
                @if (!Sentry::getUser()->hasLinkedAccount('google'))
                    <a href="{{ Sociauth::getProvider('google')->getAuthUrl() }}" class="btn" style="width: 300px; background-color: #D4261D; color: #fff;">Привязать аккаунт Google</a>
                @else
                    <a href="/settings/unlink/google" class="btn" style="width: 300px; background-color: indianred; color: #fff;">Отвязать аккаунт Google</a>
                @endif
            </div>
            <div class="form-group" style="text-align: center;">
                @if (!Sentry::getUser()->hasLinkedAccount('facebook'))
                    <a href="{{ Sociauth::getProvider('facebook')->getAuthUrl() }}" class="btn" style="width: 300px; background-color: #3B5999; color: #fff;">Привязать аккаунт Facebook</a>
                @else
                    <a href="/settings/unlink/facebook" class="btn" style="width: 300px; background-color: indianred; color: #fff;">Отвязать аккаунт Facebook</a>
                @endif
            </div>
            @else
            <p>К сожалению пользователи, прошедшие авторизацию через социальную сеть, не могут привязывать свои аккаунты.</p>
            @endif
        </div>
        <div class="col-lg-3">
        <div class="list-group">
            <a href="/settings" class="list-group-item">Информация</a>
            <a href="/settings/security" class="list-group-item">Безопасность</a>
            <a href="/settings/notifications" class="list-group-item">Уведомления</a>
            <a href="/settings/accounts" class="list-group-item active">Аккаунты</a>
        </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('/js/app/controllers/SettingsController.js') }}
@stop