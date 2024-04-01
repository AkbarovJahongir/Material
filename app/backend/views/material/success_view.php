<div class="app-title">
  <div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>">Материалы</a></li>
    </ul>
  </div>
</div>
<div class="row">
  <div class="col-md-12 content">
    <div class="tile">
      <?php
      if (isset($data["message"])){
        echo '<div class="card text-black bg-light"><div class="card-body">'.$data["message"].'</div></div><br>';
      }
      ?>
    </div>
  </div>
</div>
