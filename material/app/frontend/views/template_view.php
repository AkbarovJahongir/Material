<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Научные достижения</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini rtl  <?php if(isset($_SESSION["sidenav_toggled"])){if($_SESSION["sidenav_toggled"]==='1'){echo 'sidenav-toggled';}}?>">
    <!-- Navbar-->
    <header class="app-header">
        <a class="app-header__logo"  href="/" style="display: flex;justify-content: space-around;align-items: center;">Обычный пользователь</a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <ul class="app-nav">
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="/auth"><i class="fa fa-sign-in fa-lg"></i> Войти</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">      
      <ul class="app-menu">
        <li><a class="app-menu__item active" href="/"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Главная страныца</span></a></li>
        <li><a class="app-menu__item" href="/material"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Материалы</span></a></li>
        <li><a class="app-menu__item" href="/author"><i class="app-menu__icon fa fa-pencil"></i><span class="app-menu__label">Авторы (Учителя)</span></a></li>
        <li><a class="app-menu__item" href="/specialty"><i class="app-menu__icon fa fa-university"></i><span class="app-menu__label">Специальности</span></a></li>
        <li><a class="app-menu__item" href="/subject"><i class="app-menu__icon fa fa-leanpub"></i><span class="app-menu__label">Предметы</span></a></li>
      </ul>
    </aside>
	
    <main class="app-content">
    	<?php include 'app/frontend/views/'.$content_view; ?>
	</main>
    <!-- Essential javascripts for application to work-->
    <!--<script src="/assets/js/jquery-3.2.1.min.js"></script>-->
    <script type="text/javascript" src="/assets/js/export/jquery-3.3.1.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="/assets/js/plugins/pace.min.js"></script>

    <!-- Page specific javascripts-->
    <!--<script type="text/javascript" src="/assets/js/plugins/jquery.dataTables.min.js"></script>-->
    <script type="text/javascript" src="/assets/js/export/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript" src="/assets/js/export/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/buttons.flash.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/jszip.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/pdfmake.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/vfs_fonts.js"></script>

    <script type="text/javascript" src="/assets/js/export/buttons.html5.min.js"></script>
    <script type="text/javascript" src="/assets/js/export/buttons.print.min.js"></script>





    <script type="text/javascript">
        $('#sampleTable').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
        });
    </script>
  </body>
</html>