<!DOCTYPE html>
<html>
<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
  $language_ = [];
  include_once './app/language/Authorize/authLanguageRU.php';
  $language_ = $language;
} else {
  $language_ = [];
  include_once './app/language/Authorize/authLanguageTJ.php';
  $language_ = $language;
}
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
  <!-- Font-icon css-->
    <link rel="stylesheet" href="/assets/css/flag-icon.min.css">
  <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.min.css">
  <title><?= $language_["authorization"] ?></title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <ul class="app-nav">
    <div class="dropdown language">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">

        <?php
        if ($_SESSION["local"] == "ru"):
          ?>
          <span class="flag-icon flag-icon-ru"></span>
          <lable id="namelang"><?= $language_["languageRU"] ?></lable>
          <?php
        else:
          ?>
          <span class="flag-icon flag-icon-tj"></span>
          <lable id="namelang"><?= $language_["languageTJ"] ?></lable>
          <?php
        endif;
        ?>
      </button>
      <div class="dropdown-menu dropdown-menu-right text-right language">
        <a class="dropdown-item" onclick="setLanguageOnServer('ru')" href="#ru"><span class="flag-icon flag-icon-ru">
          </span> <?= $language_["languageRU"] ?></a>
        <a class="dropdown-item" onclick="setLanguageOnServer('tj')" href="#tj"><span class="flag-icon flag-icon-tj">
          </span> <?= $language_["languageTJ"] ?></a>
      </div>
    </div>
  </ul>
  <section class="login-content">
    <div class="login-box">
      <form class="login-form" method="POST">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i><?= $language_["authorization"] ?></h3>
        <div class="form-group">
          <input class="form-control" name="login" type="text" placeholder="<?= $language_["login"] ?>" autofocus>
        </div>
        <div class="form-group">
          <input class="form-control" name="password" type="password" placeholder="<?= $language_["password"] ?>">
        </div>
        <div class="form-group">
          <button class="btn btn-primary btn-block"><i
              class="fa fa-sign-in fa-lg fa-fw"></i><?= $language_["toComeIn"] ?></button>
        </div>
        <?php
        if (isset($data["error"])) {
          echo '<div class="form-group btn-container">
			<div class="bs-component">
			<div class="alert alert-dismissible alert-danger">
				<button class="close" type="button" data-dismiss="alert">×</button>'
            . $data["message"] . '</div>
			</div>
			</div>';
        } ?>
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
    $('.login-content [data-toggle="flip"]').click(function () {
      $('.login-box').toggleClass('flipped');
      return false;
    });
    function setLanguageOnServer(lang) {
            $.ajax({
                url: "/auth/setLanguage",
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
                    swal("<?= $language_["error"] ?>!", "Что то пошло не так!", "error");
                }
            });
        }
  </script>
</body>

</html>