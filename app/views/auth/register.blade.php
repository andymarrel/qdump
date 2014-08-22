@extends('layout')

@section('ngController')"AuthController"@stop

@section('content')
    <div class="container">
        @include('navbar', ['active' => 'auth'])
        <div class="content row">
            <div class="col-lg-7 col-lg-offset-2">
                <div id="registartion-status">

                                    </div>
                                    <form>
                                        <div class="form-group">
                                                  <label for="email" class="control-label">Э-почта</label>
                                                  <input ng-init="form.email=undefined" ng-model="form.email" class="form-control" id="email" name="email" placeholder="Электронная почта">
                                        </div>
                                        <div class="form-group">
                                              <label for="password" class="control-label">Пароль</label>
                                              <input type="password" ng-init="form.password=undefined" ng-model="form.password" class="form-control" id="password" name="password" placeholder="Пароль">
                                          </div>
                                          <div class="form-group">

                                                         <label for="password-again" class="control-label">Пароль ещё раз</label>
                                                         <input type="password" ng-init="form.passwordAgain=undefined" ng-model="form.passwordAgain" class="form-control" id="password-again" name="password-again" placeholder="Пароль ещё раз">
                                                      </div>
                                              <div class="form-group">
                                                 <label for="captcha" class="control-label">Код безопасности</label>
                                                 <input ng-init="form.captcha=undefined" ng-model="form.captcha" type="text" class="form-control" id="captcha" name="captcha" placeholder="Введите код безопасности">
                                                 <i style="display: block"><small style="color: #aeaeae">Нажмите на картинку, чтобы обновить код безопасности</small></i>
                                                 <div style="margin: 10px 0;"><span id="captcha-container" style="cursor: pointer" ng-click="auth.refreshCaptcha()">{{ HTML::image(Captcha::img(), 'Captcha') }}</span></div>
                                              </div>
                                            <div class="form-group">
                                                <button ng-click="registration.register($event, form)" class="btn btn-default" style="margin-top: 5px;">Зарегистрироваться</button>
                                            </div>
                                    </form>
                                </div>
                <div class="col-lg-3">
                    <div class="small-heading">Сообщения об ошибках</div>
                    <div class="panel">
                        <div class="panel-body">Если во время регистрации возникли ошибки, наведите мышку на красный крестик. Это позволит вам прочитать сообщение об ошибке.</div>
                    </div>
                    <div class="small-heading">Интеграция</div>
                    <div class="panel">
                        <div class="panel-body">В настройках пользователя можно привязать все аккаунты социальных сетей к учётной записи qdump.</div>
                    </div>
                </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('js/app/controllers/AuthController.js') }}
@stop