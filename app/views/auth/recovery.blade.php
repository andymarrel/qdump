@extends('page_layouts/standart')

@section('ngController')"AuthController"@stop

@section('navbar')
    @include('navbar', ['active' => 'auth'])
@stop

@section('body')
    <div class="col-lg-10 col-lg-offset-1">
        <form>
            {{ Form::token() }}
            <div class="form-group">
                <label for="email" class="control-label">Э-почта</label>
                <input ng-init="form.email=''" ng-model="form.email" class="form-control" id="email" name="email" placeholder="Электронная почта">
                <i style="font-size: small;color: #aeaeae;">На этот электронный адрес будет выслано письмо с дальнейшими действиями по восстановлению пароля</i>
            </div>
            <div class="form-group">
                <label for="captcha" class="control-label">Код безопасности</label>
                <input ng-init="form.captcha=''" ng-model="form.captcha" type="text" class="form-control" id="captcha" name="captcha" placeholder="Введите код безопасности">
                <i style="display: block"><small style="color: #aeaeae">Нажмите на картинку, чтобы обновить код безопасности</small></i>
                <div style="margin: 10px 0;"><span id="captcha-container" style="cursor: pointer" ng-click="auth.refreshCaptcha()">{{ HTML::image(Captcha::img(), 'Captcha') }}</span></div>
            </div>
            <div class="form-group">
                <button ng-click="recovery.sendToken($event, form)" class="btn btn-default">Продолжить</button>
            </div>
        </form>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('/js/app/controllers/AuthController.js') }}
@stop