<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$title;?></title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="/public/css/style.css" rel="stylesheet">
    <link href="/public/css/calendar-blue.css" rel="stylesheet">
    <script src="/public/js/jquery-3.4.1.min.js"></script>
    <script src="/public/js/calendar.js"></script>
    <script src="/public/js/form.js"></script>
    <script src="/public/js/main.js"></script>
    <!--<link href="../public/css/jquery.css" rel="stylesheet">
    <script src="../public/js/jform.js"></script>-->
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <? if(isset($_SESSION['auth_session'])) : ?>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <b class="nav-links"><? echo 'Hello';//=$vars['timeSite'] ?>, <a class="nav-links" href="../account/profile"><? echo htmlspecialchars($_SESSION['auth_session']['login']);?></a></b>
                        </li>
                <? if($_SESSION['admin']['is_admin'] == 1):
                    ?>
                      <li class="nav-item">
                            &nbsp; | <a class="nav-links" href="../admin">Админ-панель</a>
                      </li>
                        <? endif; ?>
                        <li class="nav-item">
                            &nbsp; | <a class="nav-links" href="../account/logout">Выйти</a>
                        </li>
                    </ul>
                    <? else: ?>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="../account/auth">Авторизоваться</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../account/register">Зарегистрироваться</a>
                            </li>
                        </ul>
                    <? endif; ?>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3><? echo $title; ?></h3></div>

                            <? echo $content; ?>
                        </div>
                    </div>
        </main>
    </div>
</body>
</html>