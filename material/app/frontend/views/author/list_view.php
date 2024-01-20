<style>
    span.dropdown-item{
        cursor: pointer;
    }
</style>
<div class="app-title">
    <div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>">Авторы (Учителя)</a></li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Все авторы</h3>
            <div class="tile-body">
                <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="tile-body">
                                    <table class="table table-hover table-bordered" id="sampleTable">
                                        <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Имя</th>
                                            <th>Ученая степень</th>
                                            <th>Материалы</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($data['authors'] as $author) : ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $author['name'] ?></td>
                                                <td><?= $author['degree'] ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="/material/<?= $data['controller_name'] ?>/<?= $author['id'] ?>"
                                                           class="btn btn-primary btn-sm"><i class="fa fa-lg fa-book"></i> Материалы</a>
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