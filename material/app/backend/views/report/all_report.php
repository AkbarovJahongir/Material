<style>
  span.dropdown-item {
    cursor: pointer;
  }
</style>
<div class="app-title">
  <div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>">Отчеты</a></li>
    </ul>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <h3 class="tile-title">Отчеты</h3>
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
                          <th>№</th>
                          <th>Имя</th>
                          <th>Авторы</th>
                          <th>Предметы</th>
                          <th>Тип</th>
                          <th>Специальности</th>
                          <th>Дата публикации</th>
                          <th>Статус</th>
                          <th>Зав.кафедры</th>
                          <th>Отдел науки</th>
                          <th>Файл</th>
                          <th>Файл для скачивания</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data["materials"] as $material) : ?>
                          <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $material["name"] ?></td>
                            <td><?= $material["authors"] ?></td>
                            <td><?= $material["subjects"] ?></td>
                            <td><?= $material["type_name"] ?></td>
                            <td><?= $material["specialties"] ?></td>
                            <td><?= $material["date_publish"] ?></td>
                            <td><?= $material["desciption"] ?></td>
                            <td><?= $material["user_k"] ?></td>
                            <td><?= $material["user_d"] ?></td>
                            <td><?= $material['file_path'] ?></td>
                            <td>
															<div class="btn-group">
																<?php if (!empty($material['file_path'])) : ?>
																	<a href="/app/uploads/file/<?= $material['file_path'] ?>" download class="btn btn-primary btn-sm">
																		<i class="fa fa-lg fa-book"></i> Скачать
																	</a>
																<?php else : ?>
																	<p>Файл отсутствует</p>
																<?php endif; ?>
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
<script type="text/javascript">
  $('#sampleTable').DataTable({
    dom: 'lBfrtip',
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ],
    "lengthMenu": [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ]
  });
</script>