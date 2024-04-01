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
            if (isset($data["message"])) {
                echo '<div class="card text-black bg-light"><div class="card-body">' . $data["message"] . '</div></div><br>';
            }
            ?>

            <h3 class="tile-title">Добавление нового материала</h3>
            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                <div class="tile-body">
                    <div class="form-group row">
                        <label class="control-label col-md-3">Название материала*:</label>
                        <div class="col-md-9">
                            <input name="name" class="form-control" type="text" placeholder="Введите название">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Выберите авторов*:</label>
                        <div class="col-md-9">
                            <select id="authorSelect" class="form-control" multiple="">
                                <optgroup label="Выберите автора">
                                    <?php
                                    if (isset($data["authors"])) {
                                        foreach ($data['authors'] as $row) {
                                            echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Тип материала*:</label>
                        <div class="col-md-6">
                            <select name="type" class="form-control">
                                <option value=''>Выберите тип материала</option>
                                <?php
                                if (isset($data["types"])) {
                                    foreach ($data['types'] as $row) {
                                        echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="language" class="form-control">
                                <option value=''>Выберите язык</option>
                                <?php
                                if (isset($data["languages"])) {
                                    foreach ($data['languages'] as $row) {
                                        echo "<option value='" . $row["id"] . "'>" . $row['code'] . " - " . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Выберите предмет*:</label>
                        <div class="col-md-9">
                            <select id="subjectSelect" class="form-control" multiple="">
                                <optgroup label="Выберите предмет">
                                    <?php
                                    if (isset($data["subjects"])) {
                                        foreach ($data['subjects'] as $row) {
                                            echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Выберите специальностей*:</label>
                        <div class="col-md-9">
                            <select id="specialtySelect" class="form-control" multiple="">
                                <optgroup label="Выберите специальностей">
                                    <?php
                                    if (isset($data["specialties"])) {
                                        foreach ($data['specialties'] as $row) {
                                            echo "<option value='" . $row["id"] . "'>" . $row['code'] . " - " . $row['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">Дата публикации*:</label>
                        <div class="col-md-3">
                            <input id="date_publish" name="date_publish" class="form-control" type="text" placeholder="Выберите дату">
                        </div>
                        <label class="control-label col-md-3 text-right">Выберите файл для публикации*:</label>
                        <div class="col-md-3">
                            <input type="file" class="form-control" value="Выбрать" name="fileToUpload" id="fileToUpload" required accept="file/pdf">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3">Место публикации*:</label>
                        <div class="col-md-3">
                            <select name="place" class="form-control">
                                <option value=''>Выберите место</option>
                                <?php
                                if (isset($data["places"])) {
                                    foreach ($data['places'] as $row) {
                                        echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label class="control-label col-md-3 text-right">Количество*:</label>
                        <div class="col-md-3">
                            <input name="count" class="form-control" type="number" placeholder="Введите количество">
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="control-label col-md-3">Выберите кафедру*:</label>
                        <div class="col-md-9">
                            <select name="kafedra" class="form-control">
                                <option value=''></option>
                                <?php
                                if (isset($data["kafedra"])) {
                                    foreach ($data['kafedra'] as $row) {
                                        echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-none">
                        <textarea id="json_authors" name="json_authors"></textarea>
                        <textarea id="json_subjects" name="json_subjects"></textarea>
                        <textarea id="json_specialties" name="json_specialties"></textarea>
                    </div>
                </div>
                <div class="tile-footer">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-3">
                            <input value="Добавить" class="btn btn-primary" type="submit" name="submit">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="/assets/js/plugins/select2.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    //https://select2.org/programmatic-control/methods

    $('#date_publish').datepicker({
        format: "yyyy/mm/dd",
        todayBtn: "linked",
        todayHighlight: true,
        orientation: "top",
        autoclose: true,
        todayHighlight: true
    });

    $('#authorSelect').select2();

    $('#authorSelect').on("change", function() {
        var authorJSON = JSON.stringify($(this).val());
        $('#json_authors').text(authorJSON);
    });

    $('#subjectSelect').select2();

    $('#subjectSelect').on("change", function() {
        var subjectJSON = JSON.stringify($(this).val());
        $('#json_subjects').text(subjectJSON);
    });

    $('#specialtySelect').select2();

    $('#specialtySelect').on("change", function() {
        var specialtyJSON = JSON.stringify($(this).val());
        $('#json_specialties').text(specialtyJSON);
    });
</script>