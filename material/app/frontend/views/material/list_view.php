<style>
	span.dropdown-item {
		cursor: pointer;
	}
</style>
<div class="app-title">
	<div>
		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>">Материалы</a></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<h3 class="tile-title">Все материалы</h3>
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
												<th>Авторы</th>
												<th>Предметы</th>
												<th>Тип</th>
												<th>Специальности</th>
												<th>Дата публикации</th>
												<th>Файл</th>
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
													<td>
														<div class="btn-group">
															<a href="/app/uploads/file/<?= $material['file_path'] ?> ?>/<?= $material['id'] ?>" download class="btn btn-primary btn-sm"><i class="fa fa-lg fa-book"></i> Скачать</a>
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