@extends('layout')

@section('ngController')"SettingsController"@stop

@section('content')
    <div class="container">
        @include('navbar', ['active' => 'settings'])
        <div class="col-lg-2">
        </div>
        <div class="col-lg-7">
            <div class="form-group">
                <label for="email" class="control-label">Имя</label>
                <input type="text" ng-init="form.name=''" ng-model="form.name" class="form-control" id="email" name="email" placeholder="Имя">
            </div>
            <div class="form-group">
                <label for="email" class="control-label">Фамилия</label>
                <input type="text" ng-init="form.surname=''" ng-model="form.surname" class="form-control" id="email" name="email" placeholder="Фамилия">
            </div>
            <div class="form-group">
                <label for="email" class="control-label">Место жительства</label>
                <input type="text" ng-init="form.address=''" ng-model="form.address" class="form-control" id="email" name="email" placeholder="Эстония, Таллинн, ул. Котка 1-142">
            </div>
            <div class="form-group">
                <label for="email" class="control-label">О себе</label>
                <textarea ng-init="form.about=''" ng-model="form.about" class="form-control" rows="3" placeholder="Расскажите коротко о себе"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-default" ng-click="information.changeInformation(form)" style="margin-top: 5px;">Сохранить информацию</button>
            </div>
        </div>
        <div class="col-lg-3">
        <div class="list-group">
            <a href="/settings" class="list-group-item active">Информация</a>
            <a href="/settings/security" class="list-group-item">Безопасность</a>
            <a href="/settings/notifications" class="list-group-item">Уведомления</a>
            <a href="/settings/accounts" class="list-group-item">Аккаунты</a>
        </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    {{ HTML::script('/js/app/controllers/SettingsController.js') }}
@stop