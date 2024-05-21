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

            <h3 class="tile-title"><?= $language_["changeOfScientificMaterial"] ?></h3>
            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                <div class="tile-body">
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["nameOfScientificMaterial"] ?>*:</label>
                        <div class="col-md-9">
                            <input name="name" class="form-control" type="text"
                                placeholder="<?= $language_["enterTheTitle"] ?>"
                                value='<?= $data["material"]["name"] ?>'>
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
                                        if ($row["id"] == $data["material"]["type_id"])
                                            echo "<option value='" . $row["id"] . "' selected>" . $row['name'] . "</option>";
                                        else
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
                                        if ($row["id"] == $data["material"]["language_id"])
                                            echo "<option value='" . $row["id"] . "' selected>" . $row['code'] . " - " . $row['name'] . "</option>";
                                        else
                                            echo "<option value='" . $row["id"] . "'>" . $row['code'] . " - " . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <?php
                    // Initialize $check1 and $check2 to true by default
                    $check1 = true;
                    $check2 = true;

                    if ($data["material"]["name_jurnal"] == "") {
                        $check1 = false;
                    }
                    if ($data["material"]["conference_name"] == "") {
                        $check2 = false;
                    }
                    ?>
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["conferenceTitle"] ?>*:</label>
                        <div class="col-md-7">
                            <input name="nameOfTheConference" id="nameOfTheConference" class="form-control" type="text"
                                placeholder="<?= $language_["enterTheNameOfTheConference"] ?>"
                                value="<?= $data["material"]["conference_name"] ?>" <?= $check2 ? '' : 'disabled' ?>>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="toggleCheckbox" name="checked1" class="form-check-input" type="checkbox"
                                        <?= $check2 ? 'checked' : '' ?>><?= $language_["Yes/No"] ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["magazineName"] ?>*:</label>
                        <div class="col-md-7">
                            <input name="namejurnal" id="namejurnal" class="form-control" type="text"
                                placeholder="<?= $language_["enterTheTitleOfTheMagazine"] ?>"
                                value="<?= $data["material"]["name_jurnal"] ?>"<?= $check1 ? '' : 'disabled' ?>>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="toggleCheckbox1" name="checked1" class="form-check-input" type="checkbox"
                                        <?= $check1 ? 'checked' : '' ?>><?= $language_["Yes/No"] ?>
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
                                        if ($row["id"] == $data["material"]["material_direction_id"])
                                            echo "<option value='" . $row["id"] . "' selected>" . $row['code'] . $row['name'] . "</option>";
                                        else
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
                            <input id="demoDate" name="date_publish" class="form-control" type="text"
                                placeholder="<?= $language_["selectDate"] ?>"
                                value="<?= $data["material"]["date_publish"] ?>">
                        </div>
                        <label
                            class="control-label col-md-3 text-right"><?= $language_["selectaFileToPublish"] ?>*:</label>
                        <div class="col-md-3">
                            <input type="file" class="form-control" value="<?= $language_["choose"] ?>"
                                name="fileToUpload" id="fileToUpload" required>
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
                                        if ($row["id"] == $data["material"]["pub_place_id"])
                                            echo "<option value='" . $row["id"] . "' selected>" . $row['name'] . "</option>";
                                        else
                                            echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label class="control-label col-md-3 text-right"><?= $language_["quantity"] ?>*:</label>
                        <div class="col-md-3">
                            <input name="count" class="form-control" type="number"
                                placeholder="<?= $language_["enterQuantity"] ?>"
                                value="<?= $data["material"]["count"] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["url"] ?>*:</label>
                        <div class="col-md-9">
                            <input name="urlMatrial" id="urlMatrial" class="form-control" type="text"
                                placeholder="<?= $language_["enterUrl"] ?>" value="<?= $data["material"]["url"] ?>">
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
                        <textarea id="json_authors" name="json_authors"><?= $data["json_authors"] ?></textarea>
                    </div>
                </div>
                <div class="tile-footer">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-3">
                            <input value="<?= $language_["change"] ?>" class="btn btn-primary" type="submit">
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

    $('#demoDate').datepicker({
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
    $('#authorSelect').val(<?= $data["json_authors"] ?>).trigger("change");


    document.addEventListener('DOMContentLoaded', function () {
        var checkbox = document.getElementById('toggleCheckbox');

        //alert(checkbox);
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