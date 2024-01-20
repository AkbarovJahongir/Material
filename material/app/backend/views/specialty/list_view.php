<style>
    span.dropdown-item{
        cursor: pointer;
    }
</style>
<div class="app-title">
    <div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>">Специальности</a></li>
        </ul>
    </div>
    <a class="btn btn-primary btn-sm" href="/<?= $data['controller_name'] ?>/add/">Добавить</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Все специальности</h3>
            <div class="tile-body">
                <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="tile-body">
                                    <table class="table table-hover table-bordered" id="sampleTable">
                                        <thead>
                                        <tr>
                                            <th>Код</th>
                                            <th>Специальность</th>
                                            <th>Действие</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($data['specialties'] as $specialty) : ?>
                                            <tr>
                                                <td><?= $specialty['code'] ?></td>
                                                <td><?= $specialty['name'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="/<?= $data['controller_name'] ?>/edit/<?= $specialty['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-lg fa-edit"></i> Изменить</a>
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

<!-- Page specific javascripts-->
<script type="text/javascript" src="/assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable();
</script>