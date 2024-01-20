<!DOCTYPE html>
<html lang="en">

<head>
    <title>Materials</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css">
</head>

<body class="app sidebar-mini rtl  <?php if (isset($_SESSION["sidenav_toggled"])) {
                                        if ($_SESSION["sidenav_toggled"] === '1') {
                                            echo 'sidenav-toggled';
        echo $_SESSION['users'];
                                        }
                                    } ?>">
    <!-- Navbar-->
    <header class="app-header">
    <a class="app-header__logo" href="/" style="display: flex;justify-content: space-around;align-items: center;">
    <img src="/app/uploads/image_users/<?php echo $_SESSION["uid"]["image_url"]; ?>" /><?php echo $_SESSION["uid"]["name"]; ?>
</a>

        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <ul class="app-nav">
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="/user/index"><i class="fa fa-cog fa-lg"></i> Профиль</a></li>
                    <li><a class="dropdown-item" href="/auth/logout"><i class="fa fa-sign-out fa-lg"></i> Выйти</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <ul class="app-menu">
            <?php
            $main_active = (Route::$active_controller == "main") ? "active" : "";
            $material_active = (Route::$active_controller == "material") ? "active" : "";
            $author_active = (Route::$active_controller == "author") ? "active" : "";
            $specialty_active = (Route::$active_controller == "specialty") ? "active" : "";
            $subject_active = (Route::$active_controller == "subject") ? "active" : "";
            $user_active = (Route::$active_controller == "user") ? "active" : "";
            ?>
            <li><a class="app-menu__item <?= $main_active ?>" href="/"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Главная страныца</span></a></li>
            <li class="treeview"><a class="app-menu__item <?= $material_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Материалы</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/material"><i class="icon fa fa-circle-o"></i> Все материалы</a></li>
                    <li><a class="treeview-item" href="/material/add"><i class="icon fa fa-circle-o"></i> Добвить новый</a></li>
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item <?= $author_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pencil"></i><span class="app-menu__label">Авторы (Учителя)</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/author"><i class="icon fa fa-circle-o"></i> Все авторы</a></li>
                    <li><a class="treeview-item" href="/author/add"><i class="icon fa fa-circle-o"></i> Добвить новый</a></li>
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item <?= $specialty_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-university"></i><span class="app-menu__label">Специальности</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/specialty"><i class="icon fa fa-circle-o"></i> Все специальности</a></li>
                    <li><a class="treeview-item" href="/specialty/add"><i class="icon fa fa-circle-o"></i> Добвить новый</a></li>
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item <?= $subject_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-leanpub"></i><span class="app-menu__label">Предметы</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/subject"><i class="icon fa fa-circle-o"></i> Все предметы</a></li>
                    <li><a class="treeview-item" href="/subject/add"><i class="icon fa fa-circle-o"></i> Добвить новый</a></li>
                </ul>
            </li>
            <li class="treeview"><a class="app-menu__item <?= $user_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Пользователи</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="/user/index"><i class="icon fa fa-circle-o"></i> Все пользователи</a></li>
                    <li><a class="treeview-item" href="/user/add"><i class="icon fa fa-circle-o"></i> Добвить новый</a></li>
                </ul>
            </li>
        </ul>
    </aside>

    <!-- Essential javascripts for application to work-->
    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="/assets/js/plugins/pace.min.js"></script>

    <main class="app-content">
        <?php include 'app/backend/views/' . $content_view; ?>
    </main>




</body>

</html>