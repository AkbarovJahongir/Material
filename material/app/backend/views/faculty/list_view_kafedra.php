<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
    $language_ = [];
    include_once './app/language/FacultyOrKafedra/languageRU.php';
    $language_ = $language;
} else {
    $language_ = [];
    include_once './app/language/FacultyOrKafedra/languageTJ.php';
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
            <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>/index_kafedra"><?= $language_["departments"] ?></a></li>
        </ul>
    </div>
    <a class="btn btn-primary btn-sm" onclick="openModal()"><?= $language_["add"] ?></a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title"><?= $language_["allDepartments"] ?></h3>
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
                                                    <th><?= $language_["departments"] ?></th>
                                                    <th><?= $language_["faculties"] ?></th>
                                                    <th><?= $language_["action"] ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['kafedra'] as $kafedra): ?>
                                                    <tr>
                                                        <td>
                                                            <?= $kafedra['name'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $kafedra['facultyName'] ?>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a onclick="openModals(<?= $kafedra['id'] ?>)"
                                                                    class="btn btn-primary btn-sm"><i
                                                                        class="fa fa-lg fa-edit"></i> <?= $language_["change"] ?></a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a href="#" onclick="deleteKafedra(<?= $kafedra["id"] ?>)"
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
                                    <div class="form-group row">
                                        <label class="control-label col-md-12" for="comment"><?= $language_["departmentName"] ?></label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="3" name="kafedra"
                                                id="kafedra" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-12"><?= $language_["selectFaculty"] ?>*:</label>
                                        <div class="col-md-12">
                                            <select id="facultySelect" class="form-control" required>
                                                <optgroup label="<?= $language_["selectFaculty"] ?>">
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submit" onclick="addKafedra()" style="background-color:limegreen; color:white"
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
                                    <div class="form-group row">
                                        <label class="control-label col-md-12" for="comment"><?= $language_["departmentName"] ?></label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="3" name="kafedraName"
                                                id="kafedraName" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-12"><?= $language_["selectFaculty"] ?>*:</label>
                                        <div class="col-md-12">
                                            <select id="facultySelected" class="form-control" required>
                                                <optgroup label="<?= $language_["selectFaculty"] ?>">
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submit" onclick="edit()"
                    style="background-color:limegreen; color:white" class="btn btn-secondary"
                    data-dismiss="modal"><?= $language_["change"] ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $language_["close"] ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Page specific javascripts-->
<script type="text/javascript" src="/assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/select2.min.js"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable({
        language:{           
            url: '<?=$_SESSION['local']?>'=='tj'?'/assets/json/tg.json':'/assets/json/ru.json',
        }
    });
    var $id = "";
    function openModal() {
        $.ajax({
            url: "/faculty/getFaculty",
            type: "POST",
            dataType: "json",
            cache: false,
            success: function (response) {
                if (response && !response.error) {
                    var select = $('#facultySelect').find('optgroup');
                    select.empty();
                    response.forEach(function (faculty) {
                        var option = $('<option></option>').attr('value', faculty.id).text(faculty.name);
                        select.append(option);
                    });
                } else {
                    swal("ОШИБКА!", response.message, "error");
                    console.log(id);
                    //swal("Добавлено!", response.message, "success");
                    //location.reload();
                }
            },
            error: function (er) {
                console.log(er);
                swal("ОШИБКА!", "Что-то пошло не так!", "error");
            }
        });


        $('#myModal').modal('show');
    }
    function openModals(id) {
        $.ajax({
            url: "/faculty/getKafedraById/" + id,
            type: "GET",
            dataType: "json",
            cache: false,
            success: function (response) {
                if (!response.error) {
                    $('#kafedraName').val(response.name);
                    console.log(response);
                    $id = response.id;
                    var select = $('#facultySelected').find('optgroup');
                    select.empty();
                    // Проверяем, существует ли свойство faculty в объекте response
                    if (response.faculty && Array.isArray(response.faculty)) {
                        response.faculty.forEach(function (faculty) {
                            var option = $('<option></option>').attr('value', faculty.id).text(faculty.name);
                            if (faculty.id == response.f_id) {
                                option.prop('selected', true);
                            }
                            select.append(option);
                        });
                    } else {
                        swal("ОШИБКА!", "Данные о факультетах недоступны или не найдены", "error");
                    }
                } else {
                    swal("ОШИБКА!", response.message, "error");
                }
            },
            error: function (er) {
                console.log(er);
                swal("ОШИБКА!", "Что-то пошло не так!", "error");
            }
        });


        $('#myModals').modal('show');
    }
    function addKafedra() {
        var kafedraName = $('#kafedra').val();
        var faculty =  document.getElementById('facultySelect').value;
        if (!faculty) {
            swal("Ошибка!", "Пожалуйста, выберите факультет", "error");
            return;
        }
        $.ajax({
            url: "/faculty/addKafedra",
            type: "POST",
            dataType: "json",
            data: {
                kafedra: kafedraName,
                faculty: faculty
            },
            cache: false,
            success: function (response) {
                if (response && !response.error) {
                    swal("Добавлено!", response.message, "success");
                    location.reload();
                    console.log(response.id);
                } else {
                    swal("Ошибка!", response.message, "error");
                }
            },
            error: function (er) {
                console.log(er);
                swal("Ошибка!", "Что-то пошло не так!", "error");
            }
        });
    }


    function edit() {
        // alert($("#comment").val());
        // alert($id);
        var $ID = $id;
        var $kafedra = $('#kafedraName').val();
        var $faculty =  document.getElementById('facultySelected').value;
        swal({
            title: "Вы действительно хотите изменить?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "ДА, изменить!",
            cancelButtonText: "НЕТ, отменить!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/faculty/editKafedra",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: $ID,
                        faculty: $faculty,
                        kafedra :$kafedra
                    },
                    cache: false,
                    success: function (response) {
                        if (response && !response.error) {
                            swal("Изменено!", response.message, "success");
                            //location.reload();
                        } else {
                            swal("ОШИБКА!", response.message, "error");
                            console.log(id);
                        }
                    },
                    error: function (er) {
                        console.log(er);
                        swal("ОШИБКА!", "Что-то пошло не так!", "error");
                    }
                });
            } else {
                swal("ОТМЕНЕН!", "Вы чуть не отклонили :)", "error");
            }
        });
        $id = '';
        $("#kafedraName").val('');
    }
    function deleteKafedra(id) {
        swal({
            title: "Вы действительно хотите удалить?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "ДА, удалить!",
            cancelButtonText: "НЕТ, отменить!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/faculty/deleteKafedra",
                    type: "POST",
                    dataType: "json",
                    data: "id=" + id,
                    cache: false,
                    success: function (response) {
                        if (response.error === 1) {
                            swal("ОШИБКА!", response.message, "error");
                        } else {
                            swal("УДАЛЕНО!", response.message, "success");
                            location.reload();
                        }
                    },
                    error: function (er) {
                        console.log(er);
                        swal("ОШИБКА!", "Что то пошло не так!", "error");
                    }
                });
            } else {
                swal("ОТМЕНЕН!", "Вы чуть не удалили :)", "error");
            }
        });
    }
</script>