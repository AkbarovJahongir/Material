<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css">
    <title>Authorization</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
	<div class="login-box">
    <form class="login-form" method="POST">
      <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Авторизация</h3>
      <div class="form-group">
        <input class="form-control" name="login" type="text" placeholder="Логин" autofocus>
      </div>
      <div class="form-group">
        <input class="form-control" name="password" type="password" placeholder="Пароль">
      </div>
      <div class="form-group">
        <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Войти</button>
      </div>
        <?php
        if(isset($data["error"])){
            echo '<div class="form-group btn-container">
			<div class="bs-component">
			<div class="alert alert-dismissible alert-danger">
				<button class="close" type="button" data-dismiss="alert">×</button>'
                .$data["message"].'</div>
			</div>
			</div>';
        }?>
    </form>
	</div>

    </section>

    <!-- Essential javascripts for application to work-->
    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="/assets/js/plugins/pace.min.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>


