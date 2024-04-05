<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
	span.dropdown-item {
		cursor: pointer;
	}
</style>
<div class="app-title">
	<div>
		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="/user">Пользователи</a></li>
		</ul>
	</div>
	<a class="btn btn-primary btn-sm" href="/user/add/">Добавить</a>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<h3 class="tile-title">Список пользователей</h3>
			<div class="tile-body">
				<div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-hover table-bordered dataTable no-footer" id="sampleTable"
								role="grid" aria-describedby="sampleTable_info">
								<thead>
									<tr role="row">
										<th style="width: 25px;">ID</th>
										<th style="width: 100px;">Имя</th>
										<th style="width: 100px;">Роль</th>
										<th style="width: 100px;">Логин</th>
										<th style="width: 100px;">Факультет</th>
										<th style="width: 100px;">Кафедра</th>
										<th style="width: 100px;">Фото пользователя</th>
										<th style="width: 20px;">Доступ</th>
										<th style="width: 70px;"></th>
									</tr>
								</thead>
								<tbody>
									<?php
									//print_r($data);
									// echo count($data);
									foreach ($data['users'] as $row) {
										?>
										<tr role='row'>
											<!--ID-->
											<td>
												<?= $row['id']; ?>
											</td>
											<!--Имя-->
											<td><a href='/user/edit/<?= $row['id']; ?>'>
													<?= $row['name']; ?>
												</a></td>
											<!--Роль-->
											<td>
												<?= $row['role_name']; ?>
											</td>
											<!--Логин-->
											<td>
												<?= $row['login']; ?>
											</td>
											<td>
												<?= $row['faculty']; ?>
											</td>
											<td>
												<?= $row['kafedra']; ?>
											</td>
											<td>
												<?= $row['image_url']; ?>
											</td>
											<!--Доступ-->
											<td id='access_<?= $row['id']; ?>'>
												<?= ($row['access'] ? "есть" : "нет"); ?>
											</td>
											<!---->
											<td>
												<div class='btn-group'>
													<?php
													$href = "/user/edit/" . $row['id'];
													?>
													<a href='<?= $href; ?>' class='btn btn-primary btn-sm'>
														<i class='fa fa-lg fa-edit'></i>
													</a>
												</div>
												<div class="btn-group" role="group"
													aria-label="Button group with nested dropdown">
													<span class="btn btn-primary btn-sm">действия</span>
													<div class="btn-group" role="group">
														<button class="btn btn-primary btn-sm dropdown-toggle" type="button"
															data-toggle="dropdown" aria-haspopup="true"
															aria-expanded="false"></button>
														<div id="dropdown_<?= $row['id']; ?>"
															class="dropdown-menu dropdown-menu-right"
															x-placement="bottom-end">
															<span class="dropdown-item"
																onclick="openModal(<?= $row['id'] ?>)">Сбросить
																пароль</span>
															<span class="dropdown-item"
																onclick="operation(<?= $row['id']; ?>, '<?= ($row['access'] ? "blockUser" : "unlockUser") ?>');">
																<?= ($row['access'] ? "Заблокировать" : "Разблокировать") ?>
															</span>
														</div>
													</div>
												</div>
											</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
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
				<h3 class="modal-title" id="exampleModalLabel">Обновление пароля</h3>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<form class="form-horizontal" style="margin-top: 20px;">
						<input id="Language" type="hidden" />
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label id="name" class="col-md-12" for="name">Пользователь</label>
										<label id="id" class="col-md-12" for="name" style="display: none;"></label>
										<div class="col-md-12">
											<input class="form-control" id="nameUser" readonly />
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-12" for="comment">Новый пароль</label>
										<div class="col-md-12">
											<input name="password" id="password" class="form-control" type="password"
												placeholder="Введите пароль">
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="submit" onclick="resetPassword()"
					style="background-color:limegreen; color:white" class="btn btn-secondary"
					data-dismiss="modal">Обновить</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>
<script>
	var $id = '';
	var messages = '';
	function operation(id, typeOperation) {
		// var dataString = '';
		switch (typeOperation) {
			case 'blockUser':
				messages = 'заблокировать';
				break;
			case 'unlockUser':
				messages = 'разблокировать';
				break;
		}
		swal({
			title: "Вы действительно хотите " + messages + " доспут пользователя?",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "ДА, " + messages + "!",
			cancelButtonText: "НЕТ, отменить!",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function (isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: "/user/operation",
					type: "POST",
					dataType: "json",
					data: {
						id: id,
						typeOperation: typeOperation
					},
					cache: false,
					success: function (dad) {
						if (dad.error === 1) {
							alert(dad.message);
						} else {
							//alert(dad.message.toString());
							if (typeOperation != 'resetPassword') {
								var text = (typeOperation == 'blockUser') ? 'нет' : 'есть';
								if (dad.use_elem) {
									$('#dropdown_' + id).html(dad.elem);
									$('#access_' + id).html(text);
								}

							}

							swal("Успешно!", dad.message, "success");
							location.reload();
						}
					},
					error: function (er) {
						console.log(er);
					}
				});
			} else {
				swal("ОТМЕНЕН!", "Вы чуть не " + messages + " доступ пользователя :)", "error");
			}
		});
	}

	function resetPassword() {
		// alert($("#comment").val());
		// alert($id);
		var $ID = $id;
		var $password = $("#password").val();
		swal({
			title: "Вы действительно хотите сбросить пароль?",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "ДА, сбросить!",
			cancelButtonText: "НЕТ, отменить!",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function (isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: "/user/resetPassword",
					type: "POST",
					dataType: "json",
					data: {
						id: $ID,
						password: $password
					},
					cache: false,
					success: function (response) {
						if (response.error === 1) {
							swal("ОШИБКА!", response.message, "error");
							console.log(id);
						} else {
							swal("Успешно!", response.message, "success");
							location.reload();
						}
					},
					error: function (er) {
						console.log(er);
						swal("ОШИБКА!", "Что-то пошло не так!", "error");
					}
				});
			} else {
				swal("ОТМЕНЕН!", "Вы чуть не сбросили пароль :)", "error");
			}
		});
		$id = '';
		$("#password").val('');
	}

	function openModal(id) {
		$.ajax({
			url: "/user/getUserById/" + id,
			type: "GET",
			dataType: "json",
			cache: false,
			success: function (response) {
				console.log(response[0]["name"]);
				if (response && !response.error) {
					$id = id;
					$('#nameUser').val(response[0]["name"]);
					$('#myModal').modal('show');
				} else {
					console.log("Пользователь с идентификатором не найден: " + id);
					swal("ОШИБКА!", "Пользователь не найден!", "error");
				}
			},
			error: function (err) {
				console.log(err);
				swal("ОШИБКА!", "Что-то пошло не так!", "error");
			}
		});
	}
</script>