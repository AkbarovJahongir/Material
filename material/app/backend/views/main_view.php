<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
    $title = "Главная страныца";
    $body = "Этот контент содержит инфо об этом сайте!";
} else {
  $title = "Саҳифаи асосӣ";
  $body = "Ин мундариҷа дорои маълумот дар бораи ин сайт аст!";
}
?>
<div class="app-title">
  <div>
    <h1><?= $title ?></h1>
    <p><?= $body ?></p>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
  </ul>
</div>
<div class="row">

</div>