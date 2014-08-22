<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">QDUMP</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li @if ($active == 'home')class="active"@endif><a href="/">Главная</a></li>
                <li @if ($active == 'categories')class="active"@endif><a href="#">Категории</a></li>
                <li class="dropdown @if ($active == 'new' || $active == 'top' || $active == 'hot') active @endif">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Вопросы <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Новое</a></li>
                        <li><a href="#">Лучшее</a></li>
                        <li><a href="#">Горячее</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Поиск">
                    </div>
                </form>
                <li class="dropdown @if ($active == 'auth') active @endif">
                    @if (Sentry::check())
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Sentry::getUser()->email }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/settings"><i class="fa fa-cog"></i> Настройки</a></li>
                            <li class="divider"></li>
                            <li><a href="/logout"><i class="fa fa-sign-out"></i> Выход</a></li>
                        </ul>
                    @else
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Вход <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/auth">Электронная почта</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ Sociauth::getProvider('vk')->getAuthUrl() }}"><i class="fa fa-vk"></i> Вконтакте</a></li>
                            <li><a href="{{ Sociauth::getProvider('facebook')->getAuthUrl() }}"><i class="fa fa-facebook"></i> Facebook</a></li>
                            <li><a href="{{ Sociauth::getProvider('google')->getAuthUrl() }}"><i class="fa fa-google"></i> Google</a></li>
                            <li class="divider"></li>
                            <li><a href="/register">Регистрация</a></li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>