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
	<a class="btn btn-primary btn-sm" href="/<?= $data['controller_name'] ?>/add/">Добавить</a>
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
												<th>ID</th>
												<th>Название</th>
												<th>Авторы</th>
												<th>Тип</th>
												<th>Дата публикации</th>
												<th>Действие</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($data['materials'] as $material) : ?>
												<tr>
													<td><?= $material['id'] ?></td>
													<td><?= $material['name'] ?></td>
													<td><?= $material['authors'] ?></td>
													<td><?= $material['type'] ?></td>
													<td><?= $material['date_publish'] ?></td>
													<td>
														<div style="display:flex;justify-content:space-between; padding: 10px;">
															<div class="btn-group">
																<a href="/<?= $data['controller_name'] ?>/edit/<?= $material['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-lg fa-edit"></i> Изменить</a>
															</div>
															<div class="btn-group">
																<a href="#" onclick="deleteMaterial(<?= $material['id'] ?>)" class="btn btn-danger btn-sm del-material"><i class="fa fa-lg fa-trash"></i> Удалить</a>
															</div>
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
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>
<script type="text/javascript">
	$('#sampleTable').DataTable();

	function deleteMaterial(id) {
		swal({
			title: "Вы действительно хотите удалить?",
			text: "ВАЖНО! Вы не сможете удалить тех кто уже связаны матералами",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "ДА, удалить!",
			cancelButtonText: "НЕТ, отменить!",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: "/material/delete",
					type: "POST",
					dataType: "json",
					data: "id=" + id,
					cache: false,
					success: function(response) {
						if (response.error === 1) {
							swal("ОШИБКА!", response.message, "error");
							console.log(id);
						} else {
							swal("УДАЛЕНО!", response.message, "success");
							location.reload();
						}
					},
					error: function(er) {
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