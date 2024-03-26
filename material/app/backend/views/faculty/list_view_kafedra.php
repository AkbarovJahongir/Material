<style>
    span.dropdown-item {
        cursor: pointer;
    }
</style>
<div class="app-title">
    <div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>/index_kafedra">Кафедры</a></li>
        </ul>
    </div>
    <a class="btn btn-primary btn-sm" onclick="openModal()">Добавить</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Все кафедры</h3>
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
                                                    <th>Кафедры</th>
                                                    <th>Факультеты</th>
                                                    <th>Действие</th>
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
                                                                        class="fa fa-lg fa-edit"></i> Изменить</a>
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
                                        <label class="control-label col-md-12" for="comment">Название кафедры</label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="3" name="faculty"
                                                id="faculty"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-12">Выберите факультет*:</label>
                                        <div class="col-md-12">
                                            <select id="facultySelect" class="form-control">
                                                <optgroup label="Выберите факультет">
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
                <button type="button" id="submit" onclick="addFaculty()" style="background-color:limegreen; color:white"
                    class="btn btn-secondary" data-dismiss="modal">Добавить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
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
                                        <label class="control-label col-md-12" for="comment">Название кафедры</label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="3" name="kafedraName"
                                                id="kafedraName"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-12">Выберите факультет*:</label>
                                        <div class="col-md-12">
                                            <select id="facultySelected" class="form-control">
                                                <optgroup label="Выберите факультет">
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
                <button type="button" id="submit" onclick="editSpecialty()"
                    style="background-color:limegreen; color:white" class="btn btn-secondary"
                    data-dismiss="modal">Изменить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<!-- Page specific javascripts-->
<script type="text/javascript" src="/assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable();
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
                    $id =response.id;
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

    function addFaculty() {
        var facultyName = $('#faculty').val();
        $.ajax({
            url: "/faculty/addFaculty",
            type: "POST",
            dataType: "json",
            data: {
                faculty: facultyName
            },
            cache: false,
            success: function (response) {
                if (response && !response.error) {
                    swal("Добавлено!", response.message, "success");
                    console.log(id);
                } else {
                    swal("ОШИБКА!", response.message, "error");
                    location.reload();
                }
            },
            error: function (er) {
                console.log(er);
                swal("ОШИБКА!", "Что-то пошло не так!", "error");
            }
        });
        $('#faculty').val('');
    };
    function editSpecialty() {
        // alert($("#comment").val());
        // alert($id);
        var $ID = $id;
        var $facultyName = $("#facultyName").val();
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
                    url: "/specialty/editFaculty",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: $ID,
                        facultyName: $facultyName
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
        $("#facultyName").val('');
    }
    var delayBeforeClose = 3000; // Например, 3000 миллисекунд = 3 секунды

    // Функция для закрытия сообщения
    function closeMessage() {
        var messageBlock = document.getElementById('messageBlock');
        if (messageBlock) {
            messageBlock.style.display = 'none'; // Скрыть блок сообщения
        }
    }
</script>