<div class="col-lg-2">
    <div class="list-group">
        @if (Sentry::check())
            <a href="#" class="list-group-item">Задать вопрос <span class="badge pull-right"><i class="fa fa-pencil"></i></span></a>
            <a href="#" class="list-group-item">Сообщения</a>
            <a href="#" class="list-group-item">Уведомления</a>
            <a href="#" class="list-group-item">Подписчики</a>
        @else
            <a href="/register" class="list-group-item">Зарегистрироваться</a>
        @endif
    </div>
</div>