<!doctype html>
<html lang="ru" ng-app="qdump">
<head>
    @section('meta')
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="description" content="Бесплатная база вопросов и ответов на любые вопросы">
    @show
    <title>
        @section('title')
        Qdump - база вопросов и ответов
        @show
    </title>
    @section('styles')
        {{ HTML::style('http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css') }}
        {{ HTML::style('http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
        {{ HTML::style('http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css') }}
        {{ HTML::style('http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css') }}
        {{ HTML::style('/css/jnotify/jquery.jnotify.min.css') }}

        {{ HTML::style('css/main.css') }}
    @show
</head>
<body ng-controller=@yield('ngController')>
    @yield('content')
    @section('scripts')
        {{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}

        {{ HTML::script('http://ajax.googleapis.com/ajax/libs/angularjs/1.2.21/angular.min.js') }}
        {{ HTML::script('http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
        {{ HTML::script('/js/ext/jnotify/jquery.jnotify.min.js') }}
        {{ HTML::script('/js/app/qdump.js') }}
        <script>
            @if (Session::has('notification'))
                qdump.global.sendNotification("{{ Session::get('notification')['message'] }}", "{{ Session::get('notification')['type'] }}");
            @endif
             qdump.init.tooltips();
        </script>
    @show
</body>
</html>