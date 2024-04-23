<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
    $language_ = [];
    include_once './app/language/Author/authorLanguageRU.php';
    $language_ = $language;
} else {
    $language_ = [];
    include_once './app/language/Author/authorLanguageTJ.php';
    $language_ = $language;
}
?>
<div class="app-title">
    <div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>"><?= $language_["authors"] ?></a></li>
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

            <h3 class="tile-title"><?= $language_["addingaNewAuthor"] ?></h3>
            <form class="form-horizontal" method="POST">
                <div class="tile-body">
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["authorsName"] ?>*:</label>
                        <div class="col-md-9">
                            <input name="name" class="form-control" type="text" placeholder="<?= $language_["enterYourName"] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3"><?= $language_["academicDegree"] ?>:</label>
                        <div class="col-md-9">
                            <input name="degree" class="form-control" type="text" placeholder="<?= $language_["enterAcademicDegree"] ?>">
                        </div>
                    </div>
                </div>
                <div class="tile-footer">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-3">
                            <input value="<?= $language_["add"] ?>" class="btn btn-primary" type="submit">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>