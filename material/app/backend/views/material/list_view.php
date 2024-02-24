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
									<div class="table-responsive">
										<table class="table table-hover table-bordered" id="sampleTable">
											<thead>
												<tr>
													<th>ID</th>
													<th>Название</th>
													<th>Авторы</th>
													<th>Тип</th>
													<th>Факультет</th>
													<th>Кафедра</th>
													<?php
													if ($_SESSION["uid"]["role_id"] == 3 || $_SESSION["uid"]["role_id"] == 1) {
														echo '<th>Статус</th>
															<th>Комментарий</th>';
													};
													?>
													<th>Дата публикации</th>
													<th style="height: 10px;">Действие</th>
													<th>Файл</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data['materials'] as $material) : ?>
													<tr>
														<td><?= $material['id'] ?></td>
														<td><?= $material['name'] ?></td>
														<td><?= $material['authors'] ?></td>
														<td><?= $material['type'] ?></td>
														<td><?= $material['facultet'] ?></td>
														<td><?= $material['kafedra'] ?></td>
														<?php
														if ($_SESSION["uid"]["role_id"] == 3 || $_SESSION["uid"]["role_id"] == 1) {
															echo '
														<td>' . $material['status'] . ' </td>
														<td>' . $material['comment'] . ' </td>';
														};
														?>
														<td><?= $material['date_publish'] ?></td>
														<td>
															<?php
															if ($_SESSION["uid"]["role_id"] == 3) {
																echo '
																	<div style="display:flex;justify-content:space-around;padding: 5px;">
																		<div class="btn-group">
																			<a href="#" onclick="deleteMaterial(' . $material['id'] . ')" class="btn btn-danger btn-sm del-material"><i class="fa fa-lg fa-trash"></i> Удалить</a>
																		</div>
																	</div>';
															} else if ($_SESSION["uid"]["role_id"] == 1) {
																echo '
																<div class="btn-group">
																		<a href="/' . $data['controller_name'] . '/edit/' . $material['id'] . '" class="btn btn-primary btn-sm"><i class="fa fa-lg fa-edit"></i> Изменить</a>
																	</div>
																<div style="display:flex;justify-content:space-around;padding: 5px;">
																	<div class="btn-group">
																		<a href="#" onclick="deleteMaterial(' . $material['id'] . ')" class="btn btn-danger btn-sm del-material"><i class="fa fa-lg fa-trash"></i> Удалить</a>
																	</div>
																</div>';
															}
															 else if ($_SESSION["uid"]["role_id"] == 2) {
																echo '
																	<div style="display:flex;justify-content:space-around;padding: 5px;">
																		<div class="btn-group">
																			<a href="/' . $data['controller_name'] . '/confirm/' . $material['id'] . '" class="btn btn-primary btn-sm"><i class="fa fa-lg fa-edit"></i> Подтвердить</a>
																		</div>
																		<div class="btn-group">
																		<a href="#"onclick="openModal(' . $material['id'] . ')"  class="btn btn-danger btn-sm del-material"><i class="fa fa-lg fa-trash"></i> Отклонить</a>
																		</div>
																	</div>';
															}

															?>
														</td>

														<!-- <div class="btn-group">
																			<a href="/' . $data['controller_name'] . '/edit/' . $material['id'] . '" class="btn btn-primary btn-sm"><i class="fa fa-lg fa-edit"></i> Изменить</a>
																		</div> -->
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Добавление комментарий</h3>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<form class="form-horizontal" style="margin-top: 20px;">
						<input id="Language" type="hidden" />
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label id="name" class="col-md-12" for="name">Материал</label>
										<label id="id" class="col-md-12" for="name" style="display: none;"></label>
										<div class="col-md-12">
											<input class="form-control" id="nameMaterial" readonly />
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-12" for="comment">Комментарий</label>
										<div class="col-md-12">
											<textarea class="form-control" rows="3" id="comment"></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="submit" onclick="declineMaterial(<?php $material['id'] ?>)" style="background-color:limegreen; color:white" class="btn btn-secondary" data-dismiss="modal">Отклонить</button>
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
	var $id = "";

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
		$id = '';
		$("#comment").val('');
	}

	function openModal(id) {
		$.ajax({
			url: "/material/getMaterialById/" + id,
			type: "GET",
			dataType: "json",
			cache: false,
			success: function(response) {
				console.log(response);
				if (response && !response.error) {
					$id = id;
					$('#nameMaterial').val(response["name"]);
				} else {
					console.log("Материал с идентификатором не найден: " + id);
					swal("ОШИБКА!", "Материал не найден!", "error");
				}
			},
			error: function(err) {
				console.log(err);
				swal("ОШИБКА!", "Что-то пошло не так!", "error");
			}
		});
		$('#myModal').modal('show');
	}



	function declineMaterial() {
		// alert($("#comment").val());
		// alert($id);
		var $ID = $id;
		var $comment = $("#comment").val();
		swal({
			title: "Вы действительно хотите отклонить?",
			text: "ВАЖНО! Отклоненный материал будет обратно отправлен пользователю который добавил его",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "ДА, отклонить!",
			cancelButtonText: "НЕТ, отменить!",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: "/material/decline",
					type: "POST",
					dataType: "json",
					data: {
						id: $ID,
						comment: $comment
					},
					cache: false,
					success: function(response) {
						if (response.error === 1) {
							swal("ОШИБКА!", response.message, "error");
							console.log(id);
						} else {
							swal("Откланено!", response.message, "success");
							location.reload();
						}
					},
					error: function(er) {
						console.log(er);
						swal("ОШИБКА!", "Что-то пошло не так!", "error");
					}
				});
			} else {
				swal("ОТМЕНЕН!", "Вы чуть не отклонили :)", "error");
			}
		});
		$id = '';
		$("#comment").val('');
	}
</script>