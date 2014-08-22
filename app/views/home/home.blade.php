@extends('page_layouts/standart')

@section('ngController')"HomeController"@stop

@section('navbar')
    @include('navbar', ['active' => 'home'])
@stop

@section('body')
    <div class="question" style="margin-bottom: 15px;">
                        <div class="heding">
                            <h1 style="padding: 0; margin: 0; font-size: 30px;"><a href="#">Зачем мне отвечать на вопросы?</a></h1>
                        </div>
                        <div class="tags">
                            <span>PHP</span><span>Qdump</span>
                        </div>
                        <div class="body">Зачем мне задавать вопросы тут, если я могу найти всю информацию в интернете?</div>
                        <div class="avatar-section clearfix" style="margin: 20px 0;">
                            <div style="float: left"><img src="http://cs619725.vk.me/v619725748/b1a0/QdGDXvJuQEY.jpg" style="width: 35px; height: 35px;"></div>
                            <div style="float: left; margin-left: 10px; color: #aeaeae; font-size: small"><strong><a href="#">Andymarrel</a></strong>, developer<br>Добавлено <strong>меньше часа назад</strong> в категорию <strong><a href="#">Кудамп</a></strong></div>
                        </div>
                        <div class="footer">
                            <a href="#" class="follow"><i class="fa fa-paper-plane"></i> Отслеживать <strong>10</strong></a>&nbsp;&nbsp;
                            <a href="#" class="share"><i class="fa fa-share"></i> Поделиться</a>&nbsp;&nbsp;
                            <a href="#" class="share"><i class="fa fa-pencil"></i> Ответить <strong>3</strong></a>
                        </div>
                    </div>
                    <hr>
                    <div class="question" style="margin-bottom: 15px;">
                        <div class="heding">
                            <h1 style="padding: 0; margin: 0; font-size: 30px;"><a href="#">Почему я смотрю на этот вопрос?</a></h1>
                        </div>
                        <div class="tags">
                                                <span>JavaScript</span><span>SQL</span><span>MySQL</span>
                                            </div>
                        <div class="body">Зачем мне задавать вопросы тут, если я могу найти всю информацию в интернете?</div>
                        <div class="avatar-section clearfix" style="margin: 20px 0;">
                            <div style="float: left"><img src="http://cs619725.vk.me/v619725748/b1a0/QdGDXvJuQEY.jpg" style="width: 35px; height: 35px;"></div>
                            <div style="float: left; margin-left: 10px; color: #aeaeae; font-size: small"><strong><a href="#">Andymarrel</a></strong>, developer<br>Добавлено <strong>меньше часа назад</strong> в категорию <strong><a href="#">Кудамп</a></strong></div>
                        </div>
                        <div class="footer">
                            <a href="#" class="follow"><i class="fa fa-paper-plane"></i> Отслеживать <strong>102</strong></a>&nbsp;&nbsp;
                            <a href="#" class="share"><i class="fa fa-share"></i> Поделиться</a>&nbsp;&nbsp;
                            <a href="#" class="share"><i class="fa fa-pencil"></i> Ответить <strong>12</strong></a>
                        </div>
                    </div>
                    <hr>
@stop

@section('scripts')
    @parent
    {{ HTML::script('/js/app/controllers/HomeController.js') }}
@stop