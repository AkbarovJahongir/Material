<div class="app-title">
  <div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/user">Пользователи</a></li>
      <li class="breadcrumb-item active">Редактирование</li>
    </ul>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <?php
      /*
	  echo "<pre>";
      print_r($data);
	  echo "</pre>"; die;
	  */
      $info = $data["user_info"];
      if (isset($data["message"])) {
        echo '<div class="card text-black bg-light"><div class="card-body">' . $data["message"] . '</div></div><br>';
      }
      ?>
      <? 
          foreach ($data['user'] as $row) {
        echo $row;
          }
      //$this->print_array($data["user"]);
      ?>

      <h3 class="tile-title">Редактирование: <?php echo "<span class='text-primary'> " . $info["name"] . "</span>"; ?></h3>
      <div class="tile-body">
        <form class="form-horizontal" method="POST">
          <div class="form-group row">
            <label class="control-label col-md-3">Имя *</label>
            <div class="col-md-9">
              <input name="name" class="form-control" type="text" placeholder="Введите имя" value="<?= $data["user"]["name"]?>" >
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3">Логин (Телефон) *</label>
            <div class="col-md-9">
              <input name="login" class="form-control" type="text" placeholder="Ввидите номер телефона" value="<?= $data["user"]["login"]?>">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3">Пароль *</label>
            <div class="col-md-3">
              <input name="password" class="form-control" type="password" placeholder="Введите пароль" value="<?= $data["user"]["password"]?>">
            </div>
            <label class="control-label col-md-3 text-right">Выберите фото пользователя*:</label>
            <div class="col-md-3">
              <input type="file" class="form-control" value="Выбрать" name="image_url" id="image_url" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3">Роль *</label>
            <div class="col-md-3">
              <select id="select_role" class="form-control" name="role">
                <?php if (isset($data["role"])) {
                  foreach ($data['role'] as $row) {
                    if ($row['id'] == $info["role"])
                      echo "<option selected value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                    else
                      echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                  }
                }
                ?>
              </select>
            </div>

            <label class="control-label col-md-3 text-right">Доступ для входа *</label>
            <div class="col-md-2">
              <div class="form-check">
                <label class="form-check-label">
                  <input name="access" class="form-check-input" type="checkbox" <?php echo ($info["access"] ? "checked" : "") ?>>Есть/Нет
                </label>
              </div>
            </div>
          </div>
          <div class="tile-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-3">
                <input value="Изменить" class="btn btn-primary" type="submit">
              </div>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>
<script>
  $("#select_role").on('change', function() {
    if (this.value == 5) {
      $("#deliver_block").css("display", "block");
    } else {
      $("#deliver_block").css("display", "none");
      $('input[name ="d_tel"]').val("");
      $('input[name ="d_passport"]').val("");
    }
  });
</script>