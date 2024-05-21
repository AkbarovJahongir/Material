<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
    $language_ = [];
    include_once './app/language/Material/languageRU.php';
    $language_ = $language;
} else {
    $language_ = [];
    include_once './app/language/Material/languageTJ.php';
    $language_ = $language;
}
?>
<div class="app-title">
    <div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>"><?= $language_["materials"] ?></a>
            </li>
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

            <h3 class="tile-title"><?= $language_["addingNewMaterial"] ?></h3>
            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                <div class="tile-body">
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["nameOfScientificMaterial"] ?>*:</label>
                        <div class="col-md-9">
                            <input name="name" class="form-control" type="text"
                                placeholder="<?= $language_["enterTheTitle"] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["selectAuthors"] ?>*:</label>
                        <div class="col-md-9">
                            <select id="authorSelect" class="form-control" multiple="">
                                <optgroup label="<?= $language_["SelectAuthor"] ?>">
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
                        <label class="control-label col-md-3"><?= $language_["typeofscientificmaterial"] ?>*:</label>
                        <div class="col-md-6">
                            <select name="type" class="form-control">
                                <option value=''><?= $language_["selectTheTypeOfScientificMaterial"] ?></option>
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
                                <option value=''><?= $language_["chooseLanguage"] ?></option>
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
                        <label class="control-label col-md-3"><?= $language_["conferenceTitle"] ?>*:</label>
                        <div class="col-md-7">
                            <input name="nameOfTheConference" id="nameOfTheConference" class="form-control" type="text"
                                placeholder="<?= $language_["enterTheNameOfTheConference"] ?>">
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="toggleCheckbox" name="checked1" class="form-check-input" type="checkbox"
                                        checked><?= $language_["Yes/No"] ?>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["magazineName"] ?>*:</label>
                        <div class="col-md-7">
                            <input name="namejurnal" id="namejurnal" class="form-control" type="text"
                                placeholder="<?= $language_["enterTheTitleOfTheMagazine"] ?>">
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="toggleCheckbox1" name="checked1" class="form-check-input" type="checkbox"
                                        checked><?= $language_["Yes/No"] ?>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["chooseaDirection"] ?>*:</label>
                        <div class="col-md-9">
                            <select name="direction" class="form-control">
                                <option value=''><?= $language_["chooseaDirection"] ?></option>
                                <?php
                                if (isset($data["direction"])) {
                                    foreach ($data['direction'] as $row) {
                                        echo "<option value='" . $row["id"] . "'>" . $row['code'] . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["publicationDate"] ?>*:</label>
                        <div class="col-md-3">
                            <input id="date_publish" name="date_publish" class="form-control" type="text"
                                placeholder="<?= $language_["selectDate"] ?>">
                        </div>
                        <label class="control-label col-md-3 text-right"><?= $language_["selectaFileToPublish"] ?>
                            PDF*:</label>
                        <div class="col-md-3">
                            <input type="file" class="form-control" lang="" value="<?= $language_["choose"] ?>"
                                name="fileToUpload" id="fileToUpload" required accept="file/pdf" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["placeOfPublication"] ?>*:</label>
                        <div class="col-md-3">
                            <select name="place" class="form-control">
                                <option value=''><?= $language_["selectaLocation"] ?></option>
                                <?php
                                if (isset($data["places"])) {
                                    foreach ($data['places'] as $row) {
                                        echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label class="control-label col-md-3 text-right"><?= $language_["quantity"] ?>*:</label>
                        <div class="col-md-3">
                            <input name="count" class="form-control" type="number"
                                placeholder="<?= $language_["enterQuantity"] ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["url"] ?>*:</label>
                        <div class="col-md-9">
                            <input name="urlMatrial" id="urlMatrial" class="form-control" type="text"
                                placeholder="<?= $language_["enterUrl"] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["selectDepartment"] ?>*:</label>
                        <div class="col-md-9">
                            <?php
                            if (isset($data["kafedra"])) {
                                foreach ($data['kafedra'] as $row) {
                                    if ($row["id"] == $_SESSION["uid"]["kafedra_id"])
                                        echo '<input name="kafedra" class="form-control" readonly value="' . $row["name"] . '">';

                                }
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                <div class="d-none">
                    <textarea id="json_authors" name="json_authors"></textarea>
                </div>
        </div>
        <div class="tile-footer">
            <div class="row">
                <div class="col-md-8 col-md-offset-3">
                    <input value="<?= $language_["add"] ?>" class="btn btn-primary" type="submit" name="submit"
                        required>
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

    $('#authorSelect').on("change", function () {
        var authorJSON = JSON.stringify($(this).val());
        $('#json_authors').text(authorJSON);
    });

    $('#subjectSelect').select2();

    $('#subjectSelect').on("change", function () {
        var subjectJSON = JSON.stringify($(this).val());
        $('#json_subjects').text(subjectJSON);
    });

    $('#specialtySelect').select2();

    $('#specialtySelect').on("change", function () {
        var specialtyJSON = JSON.stringify($(this).val());
        $('#json_specialties').text(specialtyJSON);
    });
    document.addEventListener('DOMContentLoaded', function () {
        var checkbox = document.getElementById('toggleCheckbox');

        var checkbox1 = document.getElementById('toggleCheckbox1');

        checkbox.addEventListener('change', function () {
            if (this.checked) {
                document.getElementById("nameOfTheConference").disabled = false;
            } else {
                document.getElementById("nameOfTheConference").disabled = true;
            }
        });
        checkbox1.addEventListener('change', function () {
            if (this.checked) {
                document.getElementById("namejurnal").disabled = false;
            } else {
                document.getElementById("namejurnal").disabled = true;
            }
        });
    });
</script>