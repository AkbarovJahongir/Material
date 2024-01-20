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
      if (isset($data["message"])) {
        echo '<div class="card text-black bg-light"><div class="card-body">' . $data["message"] . '</div></div><br>';
      }
      ?>
      <h3 class="tile-title">Добавление нового пользователя</h3>
      <div class="tile-body">
        <form class="form-horizontal" method="POST" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="control-label col-md-3">Имя*:</label>
            <div class="col-md-9">
              <input name="name" class="form-control" type="text" placeholder="Введите имя">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3">Фамилия*:</label>
            <div class="col-md-9">
              <input name="surname" class="form-control" type="text" placeholder="Введите фамилия">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3">Отчество*:</label>
            <div class="col-md-9">
              <input name="father_name" class="form-control" type="text" placeholder="Введите отчество">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3">Логин (Телефон)*:</label>
            <div class="col-md-9">
              <input name="login" class="form-control" type="text" placeholder="Ввидите номер телефона">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3">Пароль*:</label>
            <div class="col-md-3">
              <input name="password" class="form-control" type="password" placeholder="Введите пароль">
            </div>
            <label class="control-label col-md-3 text-right">Выберите файл для публикации*:</label>
            <div class="col-md-3">
              <input type="file" class="form-control" value="Выбрать" name="fileToUpload" id="fileToUpload" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-3">Роль*:</label>
            <div class="col-md-3">
              <select class="form-control" name="role" id="select_role">
                <?php if (isset($data["role"])) {
                  foreach ($data['role'] as $row) {
                    echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                  }
                }
                ?>
              </select>
            </div>

            <label class="control-label col-md-3 text-right" style="text-align: right;">Доступ для входа*:</label>
            <div class="col-md-3">
              <div class="form-check">
                <label class="form-check-label">
                  <input name="access" class="form-check-input" type="checkbox" checked>Есть/Нет
                </label>
              </div>
            </div>
          </div>
          <div class="tile-footer">
            <div class="row">
              <div class="col-md-9 col-md-offset-3">
                <input value="Добавить" class="btn btn-primary" type="submit">
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
      $('input[name ="d_sms"]').prop('checked', true);
    } else {
      $("#deliver_block").css("display", "none");
      $('input[name ="d_sms"]').prop('checked', false);
      $('input[name ="d_tel"]').val("");
      $('input[name ="d_passport"]').val("");
    }
  });
</script>