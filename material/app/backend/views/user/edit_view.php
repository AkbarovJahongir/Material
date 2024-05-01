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
        echo '<div id="messageBlock" class="card text-black bg-light"><div class="card-body">' . $data["message"] . '</div></div><br>';
      }
      ?>

      <h3 class="tile-title">Редактирование:
        <?php echo "<span class='text-primary'> " . $data["user"][0]["name"] . "</span>"; ?>
      </h3>
      <div class="tile-body">
        <form class="form-horizontal" method="POST">
          <div class="form-group row">
            <label class="control-label col-md-2">Имя *</label>
            <div class="col-md-10">
              <input name="name" class="form-control" type="text" placeholder="Введите имя"
                value="<?= $data["user"][0]["name"] ?>">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-2">Логин (Телефон) *</label>
            <div class="col-md-10">
              <input name="login" class="form-control" type="text" placeholder="Ввидите номер телефона"
                value="<?= $data["user"][0]["login"] ?>">
            </div>
          </div>

          <div class="form-group row" id="kafedra">
            <label class="control-label col-md-2">Кафедра*:</label>
            <div class="col-md-10">
              <select class="form-control" name="kafedra" id="select_kafedra">
                <?php if (isset($data["kafedra"])) {
                  foreach ($data['kafedra'] as $row) {
                    if ($row == $data["user"][0]["kafedra_id"])
                      echo "<option selected value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                    else
                      echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Роль *</label>
            <div class="col-md-2">
              <select id="select_role" class="form-control" name="role">
                <?php if (isset($data["role"])) {
                  foreach ($data['role'] as $row) {
                    if ($row['id'] == $data["user"][0]["role_id"]) {
                      echo "<option selected value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                    } else
                      echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                  }
                }
                ?>
              </select>
            </div>
            <label class="control-label col-md-2 text-right">Выберите фото пользователя*:</label>
            <div class="col-md-2">
              <input type="file" class="form-control" name="image_url" id="image_url" required
                accept="image/png, image/jpeg, image/jpg">
            </div>
            <label class="control-label col-md-2 text-right">Доступ для входа *</label>
            <div class="col-md-2">
              <div class="form-check">
                <label class="form-check-label">
                  <input name="access" class="form-check-input" type="checkbox" <?php echo ($data["user"][0]["access"] ? "checked" : "") ?>>Есть/Нет
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row" id="author_id">
            <label class="control-label col-md-2">Если пользователь явялется автором выберите автора*</label>
            <div class="col-md-10">
              <select class="form-control" name="author" id="select_author">
                <?php if (isset($data["author"])) {
                  foreach ($data['author'] as $row) {
                    if ($row == $data["user"][0]["author_id"])
                      echo "<option selected value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                    else
                      echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                  }
                }
                ?>
              </select>
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
<script type="text/javascript" src="/assets/js/plugins/select2.min.js"></script>
<script>
$('#select_author').select2();
  $("#select_role").on('change', function () {
    if (this.value == 5) {
      $("#deliver_block").css("display", "block");
    } else {
      $("#deliver_block").css("display", "none");
      $('input[name ="d_tel"]').val("");
      $('input[name ="d_passport"]').val("");
    }
    if (this.value == 2) {
      $("#kafedra").show();
    } else {
      $("#kafedra").hide();
    }
  });
  document.addEventListener("DOMContentLoaded", function () {
    var roleSelect = document.getElementById("select_role");
    var kafedraDiv = document.getElementById("kafedra");

    roleSelect.addEventListener("change", function () {
      var selectedRoleId = this.value;
      if (selectedRoleId === "2" || selectedRoleId === "1") {
        kafedraDiv.style.display = "block";
        kafedraDiv.style.display = "flex";
      } else {
        kafedraDiv.style.display = "none";
      }
    });

    if (roleSelect.value === "2" || roleSelect.value === "1") {
      kafedraDiv.style.display = "block";
      kafedraDiv.style.display = "flex";
    } else {
      kafedraDiv.style.display = "none";
    }
  });
  var delayBeforeClose = 3000;
  function closeMessage() {
    var messageBlock = document.getElementById('messageBlock');
    if (messageBlock) {
      messageBlock.style.display = 'none';
    }
  }
  setTimeout(closeMessage, delayBeforeClose);
</script>