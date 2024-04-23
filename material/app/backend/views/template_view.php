<!DOCTYPE html>
<html lang="en">
<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
    $language_ = [];
    include_once './app/language/templateLanguage/templateLanguageRU.php';
    $language_ = $language;
} else {
    $language_ = [];
    include_once './app/language/templateLanguage/templateLanguageTJ.php';
    $language_ = $language;
}
?>

<head>
    <title><?= $language_["nameProjectAll"] ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/apexcharts.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" href="/assets/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css">
</head>
<style type="text/css">
    .dropdown.language {
        position: absolute;
        right: 70px;
        width: auto;
        top: 10px;
        margin-right: 10px;
    }

    @media (max-width: 991px) {
        .dropdown.language {
            right: 100px;
            position: absolute;
            top: 10px;
        }
    }
</style>

<body class="app sidebar-mini rtl  <?php if (isset($_SESSION["sidenav_toggled"])) {
    if ($_SESSION["sidenav_toggled"] === '1') {
        echo 'sidenav-toggled';
        echo $_SESSION['users'];
    }
} ?>">
    <!-- Navbar-->
    <header class="app-header">
        <a class="app-header__logo" href="/" style="display: flex;justify-content: space-around;align-items: center;">
            <img
                src="/app/uploads/image_users/<?php echo $_SESSION["uid"]["image_url"]; ?>" /><?php echo $_SESSION["uid"]["name"]; ?>
        </a>

        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

        <ul class="app-nav">
            <div class="dropdown language">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    
                    <?php
                        if ($_SESSION["local"] == "ru") :
                    ?>
                    <span class="flag-icon flag-icon-ru"></span>
                    <lable id="namelang"><?= $language_["languageRU"] ?></lable>
                    <?php
                        else :
                    ?>
                    <span class="flag-icon flag-icon-tj"></span>
                    <lable id="namelang"><?= $language_["languageTJ"] ?></lable>
                    <?php
                        endif;
                    ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right text-right language">
                    <a class="dropdown-item" onclick="setLanguageOnServer('ru')" href="#ru"><span
                            class="flag-icon flag-icon-ru"> </span> <?= $language_["languageRU"] ?></a>
                    <a class="dropdown-item" onclick="setLanguageOnServer('tj')" href="#tj"><span
                            class="flag-icon flag-icon-tj"> </span> <?= $language_["languageTJ"] ?></a>
                </div>
            </div>
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"
                    aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <? 
                    if ($_SESSION["uid"]["role_id"] == 3 || $_SESSION["uid"]["role_id"] == 4) :
                    ?>
                    <li><a class="dropdown-item" href="/user/index"><i class="fa fa-cog fa-lg"></i> <?= $language_["profile"] ?></a></li>
                    <li><a class="dropdown-item" href="/auth/logout"><i class="fa fa-sign-out fa-lg"></i> <?= $language_["exit"] ?></a></li>
                    <?php
                        else :
                    ?>
                    <li><a class="dropdown-item" href="/auth/logout"><i class="fa fa-sign-out fa-lg"></i> <?= $language_["exit"] ?></a></li>
                    <?php
                        endif;
                    ?>
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
            $faculty_active = (Route::$active_controller == "faculty") ? "active" : "";
            $subject_active = (Route::$active_controller == "subject") ? "active" : "";
            $user_active = (Route::$active_controller == "user") ? "active" : "";
            $report_active = (Route::$active_controller == "report") ? "active" : "";

            if ($_SESSION["uid"]["role_id"] == 3 || $_SESSION["uid"]["role_id"] == 4) {
                echo
                    '<li><a class="app-menu__item <?= $main_active ?>" href="/"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">' .$language_["homePage"]. '</span></a></li>';
                if ($_SESSION["uid"]["role_id"] == 3) {
                    echo '
                    <li class="treeview"><a class="app-menu__item <?= $material_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">'.$language_["scientificMaterials"].'</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item" href="/material"><i class="icon fa fa-circle-o"></i>'.$language_["allScientificMaterials"].'</a></li>
                            <li><a class="treeview-item" href="/subject/type"><i class="icon fa fa-circle-o"></i>'.$language_["typeOfScientificMaterial"].'</a></li>
                        </ul>
                    </li>';
                } else if ($_SESSION["uid"]["role_id"] == 4) {
                    echo
                        '<li class="treeview"><a class="app-menu__item <?= $material_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">'.$language_["scientificMaterials"].'</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a class="treeview-item" href="/material/get"><i class="icon fa fa-circle-o"></i> '.$language_["allScientificMaterials"].'</a></li>
                        <li><a class="treeview-item" href="/subject/type"><i class="icon fa fa-circle-o"></i> '.$language_["typeOfScientificMaterial"].'</a></li>
                    </ul>
                </li>';
                }
                echo
                    '
                    <li class="treeview"><a class="app-menu__item <?= $author_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pencil"></i><span class="app-menu__label">'.$language_["authors (Teachers)"].'</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item" href="/author"><i class="icon fa fa-circle-o"></i> '.$language_["allAuthors"].'</a></li>
                            <li><a class="treeview-item" href="/author/add"><i class="icon fa fa-circle-o"></i> '.$language_["addNew"].'</a></li>
                        </ul>
                    </li>
                    
                    <li class="treeview"><a class="app-menu__item <?= $specialty_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-university"></i><span class="app-menu__label">'.$language_["faculties"].'</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item" href="/faculty"><i class="icon fa fa-circle-o"></i> '.$language_["allFaculties"].'</a></li>
                            <li><a class="treeview-item" href="/faculty/index_kafedra"><i class="icon fa fa-circle-o"></i> '.$language_["allDepartments"].'</a></li>
                        </ul> 
                    </li>
                    <li class="treeview"><a class="app-menu__item <?= $specialty_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list-alt"></i><span class="app-menu__label">'.$language_["specialties"].'</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item" href="/specialty"><i class="icon fa fa-circle-o"></i> '.$language_["allSpecialties"].'</a></li>
                            <li><a class="treeview-item" href="/specialty/add"><i class="icon fa fa-circle-o"></i> '.$language_["addNew"].'</a></li>
                        </ul> 
                    </li>
                    <li class="treeview"><a class="app-menu__item <?= $subject_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-leanpub"></i><span class="app-menu__label">'.$language_["items"].'</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item" href="/subject"><i class="icon fa fa-circle-o"></i> '.$language_["allThings"].'</a></li>
                            <li><a class="treeview-item" href="/subject/add"><i class="icon fa fa-circle-o"></i> '.$language_["addNew"].'</a></li>
                        </ul>
                    </li>';
                if ($_SESSION["uid"]["role_id"] == 3) {
                    echo '
                    <li class="treeview"><a class="app-menu__item <?= $user_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">'.$language_["users"].'</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item" href="/user/index"><i class="icon fa fa-circle-o"></i> '.$language_["allUsers"].'</a></li>
                            <li><a class="treeview-item" href="/user/add"><i class="icon fa fa-circle-o"></i> '.$language_["addNew"].'</a></li>
                        </ul>
                    </li>';
                }
                echo '
                    <li class="treeview"><a class="app-menu__item <?= $report_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">'.$language_["reports"].'</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item" href="/report/allReport"><i class="icon fa fa-circle-o"></i> '.$language_["allReports"].'</a></li>
                            <li><a class="treeview-item" href="/report/report_barchart"><i class="icon fa fa-circle-o"></i> '.$language_["graphicReport"].'</a></li>
                        </ul>
                    </li>';
            }
            if ($_SESSION["uid"]["role_id"] == 2 || $_SESSION["uid"]["role_id"] == 1) {
                echo
                    '<li class="treeview"><a class="app-menu__item <?= $material_active ?>" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">'.$language_["scientificMaterials"].'</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a class="treeview-item" href="/material/get"><i class="icon fa fa-circle-o"></i> '.$language_["allScientificMaterials"].'</a></li>
                                <li><a class="treeview-item" href="/material/add"><i class="icon fa fa-circle-o"></i> '.$language_["addNew"].'</a></li>
                            </ul>
                        </li>';
            }
            ?>
        </ul>
    </aside>

    <!-- Essential javascripts for application to work-->
    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="/assets/js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/apexcharts.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/buttons.flash.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/jszip.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/pdfmake.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/vfs_fonts.js"></script>

    <script type="text/javascript" src="/assets/js/plugins/chart.js"></script>
    <script type="text/javascript" src="/assets/js/export/buttons.html5.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/buttons.print.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>

    <main class="app-content">
        <?php include 'app/backend/views/' . $content_view; ?>
    </main>
    <script>

        function setLanguageOnServer(lang) {
            $.ajax({
                url: "/main/setLanguage",
                type: "POST",
                dataType: "json",
                data: { language: lang },
                cache: false,
                success: function (response) {
                    if (response !== null) {
                        //alert('Язык установлен');
                        //getLanguage(response)
                        var element = document.querySelector('.flag-icon');
                        var namelang = document.getElementById('namelang');
                        if (lang === 'ru') {
                            element.className = 'flag-icon flag-icon-ru';
                            namelang.textContent = 'Русский';
                            //setLanguageOnServer('ru');
                            //location.reload();
                        } else if (lang === 'tj') {
                            element.className = 'flag-icon flag-icon-tj';
                            namelang.textContent = 'Точики';
                            //setLanguageOnServer('tj');
                        }

                        location.reload();
                    } else {
                        swal("Язык не устновлен!", "danger");
                        location.reload();
                    }
                },
                error: function (er) {
                    console.log(er);
                    swal("ОШИБКА!", "Что то пошло не так!", "error");
                }
            });
        }

    </script>
</body>

</html>