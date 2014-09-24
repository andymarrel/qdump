@extends('layout')

@section('ngController')"AuthController"@stop

@section('content')
    <div class="container">
        @include('navbar', ['active' => 'auth'])
        <div class="content row">
            <div class="col-lg-7 col-lg-offset-2">
                <div id="auth-status"></div>
                            <form>
                                <div class="form-group">
                                    <label for="email" class="control-label">Э-почта</label>
                                    <input type="text" ng-init="form.email=undefined" ng-model="form.email" class="form-control" id="email" name="email" placeholder="Электронная почта">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label">Пароль</label>
                                    <input ng-init="form.password=undefined" ng-model="form.password" type="password" class="form-control" id="password" name="password" placeholder="Пароль">
                                  </div>
                                  <div class="form-group">
                                       <label for="captcha" class="control-label">Код безопасности</label>
                                       <input ng-init="form.captcha=undefined"  ng-model="form.captcha" autocomplete="off" type="text" class="form-control" id="captcha" name="captcha" placeholder="Введите код безопасности">
                                       <i style="display: block"><small style="color: #aeaeae">Нажмите на картинку, чтобы обновить код безопасности</small></i>
                                       <div style="margin: 10px 0;"><span id="captcha-container" style="cursor: pointer" ng-click="global.refreshCaptcha()">{{ HTML::image(Captcha::img(), 'Captcha') }}</span></div>
                                  </div>
                                  <div class="form-group">
                                        <div class="checkbox">
                                          <label>
                                            <input type="checkbox" ng-init="form.remember=false" ng-model="form.remember"> Запомнить меня
                                          </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-default" ng-click="auth.authenticate($event, form)" style="margin-top: 5px;">Войти</button>
                                    </div>
                            </form>
                        </div>
            <div class="col-lg-3">

                <div class="small-heading">
                                                    Напоминание пароля
                                                </div>
                                                <div class="panel">
                                                    <div class="panel-body">
                                                        Если вы забыли пароль, то его всегда можно восстановить, пройдя по <a href="/recovery">этой ссылке</a>
                                                    </div>
                                                </div>
                <div class="small-heading">
                                    Интеграция
                                </div>
                                <div class="panel">
                                    <div class="panel-body">
                                        В настройках пользователя можно привязать все аккаунты социальных сетей к учётной записи qdump.
                                    </div>
                                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('js/app/controllers/AuthController.js') }}
@stop