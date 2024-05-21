<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
    $language_ = [];
    include_once './app/language/Place/languageRU.php';
    $language_ = $language;
} else {
    $language_ = [];
    include_once './app/language/Place/languageTJ.php';
    $language_ = $language;
}
?>
<style>
    span.dropdown-item {
        cursor: pointer;
    }
</style>
<div class="app-title">
    <div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>"><?= $language_["places"] ?></a></li>
        </ul>
    </div>
    <a class="btn btn-primary btn-sm" onclick="openModal()"><?= $language_["add"] ?></a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title"><?= $language_["allplaces"] ?></h3>
            <div class="tile-body">
                <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="tile-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered" id="sampleTable">
                                            <thead>
                                                <tr>
                                                    <th><?= $language_["place"] ?></th>
                                                    <th><?= $language_["action"] ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['place'] as $place): ?>
                                                    <tr>
                                                        <td>
                                                            <?= $place['name'] ?>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a onclick="openModals(<?= $place['id'] ?>)"
                                                                    class="btn btn-primary btn-sm"><i
                                                                        class="fa fa-lg fa-edit"></i> <?= $language_["change"] ?></a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a href="#" onclick="deleteplace(<?= $place["id"] ?>)"
                                                                    class="btn btn-danger btn-sm del-author"><i
                                                                        class="fa fa-lg fa-trash"></i> <?= $language_["delete"] ?></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12">
                    <form class="form-horizontal" style="margin-top: 20px;">
                        <input id="Language" type="hidden" />
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-12" for="comment"><?= $language_["placeName"] ?></label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="3" name="place"
                                                id="place"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submit" onclick="add()" style="background-color:limegreen; color:white"
                    class="btn btn-secondary" data-dismiss="modal"><?= $language_["add"] ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $language_["close"] ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12">
                    <form class="form-horizontal" style="margin-top: 20px;">
                        <input id="Language" type="hidden" />
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-12" for="comment"><?= $language_["placeName"] ?></label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="3" name="placeName"
                                                id="placeName"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submit" onclick="edit()" style="background-color:limegreen; color:white"
                    class="btn btn-secondary" data-dismiss="modal"><?= $language_["change"] ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $language_["close"] ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Page specific javascripts-->
<script type="text/javascript" src="/assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable({
        language:{           
            url: '<?=$_SESSION['local']?>'=='tj'?'/assets/json/tg.json':'/assets/json/ru.json',
        }
    });
    var $id = "";
    function openModal() {
        $('#myModal').modal('show');
    }
    function openModals(id) {
        $.ajax({
            url: "/place/getPlaceById/" + id,
            type: "GET",
            dataType: "json",
            cache: false,
            success: function (response) {
                if (response && !response.error) {
                    $id = id;
                    $('#placeName').val(response["name"]);
                } else {
                    swal("<?= $language_["error"] ?>!", response.message, "error");
                    console.log(id);
                    //swal("Добавлено!", response.message, "success");
                    //location.reload();
                }
            },
            error: function (er) {
                console.log(er);
                swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
            }
        });
        $('#myModals').modal('show');
    }

    function add() {
        var placeName = $('#place').val();
        $.ajax({
            url: "/place/add",
            type: "POST",
            dataType: "json",
            data: {
                place: placeName
            },
            cache: false,
            success: function (response) {
                if (response && !response.error) {
                    swal("Добавлено!", response.message, "success");
                    //location.reload();
                    //console.log(id);
                } else {
                    swal("<?= $language_["error"] ?>!", response.message, "error");
                }
            },
            error: function (er) {
                console.log(er);
                swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
            }
        });
        $('#place').val('');
    };
    function edit() {
        // alert($("#comment").val());
        // alert($id);
        var $ID = $id;
        var $placeName = $("#placeName").val();
        swal({
            title: "<?= $language_["titleError"] ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "<?= $language_["confirmEdit"] ?>",
            cancelButtonText: "<?= $language_["rejectEdit"] ?>",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/place/edit",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: $ID,
                        placeName: $placeName
                    },
                    cache: false,
                    success: function (response) {
                        if (response && !response.error) {
                            swal("Изменено!", response.message, "success");
                            //location.reload();
                        } else {
                            swal("<?= $language_["error"] ?>!", response.message, "error");
                            console.log(id);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        swal("<?= $language_["error"] ?>!", "Некоторые данные пусты или факультет с таким именем существует!", "error");
                    }
                });
            } else {
                swal("<?= $language_["canceled"] ?>!", "Вы чуть не изменили :)", "error");
            }
        });
        $id = '';
        $("#placeName").val('');
    }

    function deleteplace(id) {
        swal({
            title: "<?= $language_["titleErrorDelete"] ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "ДА, удалить!",
            cancelButtonText: "<?= $language_["rejectEdit"] ?>",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/place/delete",
                    type: "POST",
                    dataType: "json",
                    data: "id=" + id,
                    cache: false,
                    success: function (response) {
                        if (response.error === 1) {
                            swal("<?= $language_["error"] ?>!", response.message, "error");
                        } else {
                            swal("УДАЛЕНО!", response.message, "success");
                            location.reload();
                        }
                    },
                    error: function (er) {
                        console.log(er);
                        swal("<?= $language_["error"] ?>!", "Что то пошло не так!", "error");
                    }
                });
            } else {
                swal("<?= $language_["canceled"] ?>!", "Вы чуть не удалили :)", "error");
            }
        });
    }
</script>