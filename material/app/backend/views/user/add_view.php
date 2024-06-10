<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
    $language_ = [];
    include_once './app/language/Users/languageRU.php';
    $language_ = $language;
} else {
    $language_ = [];
    include_once './app/language/Users/languageTJ.php';
    $language_ = $language;
}
?>
<div class="app-title">
  <div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/user"><?= $language_["users"] ?></a></li>
      <li class="breadcrumb-item active"><?= $language_["addition"] ?></li>
    </ul>
  </div>
</div>

<div class="row">
  <div class="col-md-12 content">
    <div class="tile">
      <?php
      if (isset($data["message"])) {
				echo '<div id="messageBlock" class="card text-black bg-light"><div class="card-body">' . $data["message"] . '</div></div><br>';
			}
      ?>
      <h3 class="tile-title"><?= $language_["addingaNewUser"] ?></h3>
      <div class="tile-body">
        <form class="form-horizontal" method="POST" enctype="multipart/form-data">
          <div class="form-group row">
            <label class="control-label col-md-3"><?= $language_["name"] ?>*:</label>
            <div class="col-md-9">
              <input name="name" class="form-control" type="text" placeholder="<?= $language_["enterYourName"] ?>">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><?= $language_["surname"] ?>*:</label>
            <div class="col-md-9">
              <input name="surname" class="form-control" type="text" placeholder="<?= $language_["enterLastName"] ?>  ">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><?= $language_["patronymic"] ?>*:</label>
            <div class="col-md-9">
              <input name="father_name" class="form-control" type="text" placeholder="<?= $language_["enterMiddleName"] ?>">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><?= $language_["login (Phone)"] ?>*:</label>
            <div class="col-md-9">
              <input name="login" class="form-control" type="text" placeholder="<?= $language_["seeThePhoneNumber"] ?>">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><?= $language_["password"] ?>*:</label>
            <div class="col-md-3">
              <input name="password" class="form-control" type="password" placeholder="<?= $language_["enterPassword"] ?>">
            </div>
            <label class="control-label col-md-3 text-right"><?= $language_["selectPhoto"] ?>*:</label>
            <div class="col-md-3">
              <input type="file" class="form-control" name="image_url" id="image_url" required
                accept="image/png, image/jpeg, image/jpg">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-3"><?= $language_["role"] ?>*:</label>
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

            <label class="control-label col-md-3 text-right" style="text-align: right;"><?= $language_["loginAccess"] ?>*:</label>
            <div class="col-md-3">
              <div class="form-check">
                <label class="form-check-label">
                  <input name="access" class="form-check-input" type="checkbox" checked><?= $language_["Yes/No"] ?>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row" id="kafedra">
            <label class="control-label col-md-3"><?= $language_["department"] ?>*:</label>
            <div class="col-md-9">
              <select class="form-control" name="kafedra" id="select_kafedra">
                <?php if (isset($data["kafedra"])) {
                  foreach ($data['kafedra'] as $row) {
                    echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-3"><?= $language_["author"] ?>*</label>
            <div class="col-md-9">
              <select class="form-control" name="author" id="select_author">
              <option selected value=""><?= $language_["selectAuthor"] ?>...</option>
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
              <div class="col-md-9 col-md-offset-3">
                <input value="<?= $language_["add"] ?>" class="btn btn-primary" type="submit">
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
      $('input[name ="d_sms"]').prop('checked', true);
    } else {
      $("#deliver_block").css("display", "none");
      $('input[name ="d_sms"]').prop('checked', false);
      $('input[name ="d_tel"]').val("");
      $('input[name ="d_passport"]').val("");
    }
    if (this.value == 2 || this.value == 1) {
      $("#kafedra").show();
    } else {
      $("#kafedra").hide();
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