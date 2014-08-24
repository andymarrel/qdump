@extends('page_layouts/standart')

@section('ngController')"AuthController"@stop

@section('navbar')
    @include('navbar', ['active' => 'auth'])
@stop

@section('body')
    <div class="col-lg-10 col-lg-offset-1">
        <form>
            <div class="form-group">
                <label for="email" class="control-label">Э-почта</label>
                <input ng-init="form.email=undefined" ng-model="form.email" class="form-control" id="email" name="email" placeholder="Электронная почта">
                <i style="font-size: small;color: #aeaeae;">На этот электронный адрес будет выслано письмо с дальнейшими действиями по восстановлению пароля</i>
            </div>
            <div class="form-group">
                <button ng-click="recovery.sendToken(form)" class="btn btn-default">Продолжить</button>
            </div>
        </form>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('/js/app/controllers/AuthController.js') }}
@stop