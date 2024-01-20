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
							<table class="table table-hover table-bordered dataTable no-footer" id="sampleTable" role="grid" aria-describedby="sampleTable_info">
								<thead>
									<tr role="row">
										<th style="width: 25px;">ID</th>
										<th style="width: 100px;">Имя</th>
										<th style="width: 100px;">Роль</th>
										<th style="width: 100px;">Логин</th>
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
											<td><?= $row['id']; ?></td>
											<!--Имя-->
											<td><a href='/user/edit/<?= $row['id']; ?>'><?= $row['name']; ?></a></td>
											<!--Роль-->
											<td><?= $row['role_name']; ?></td>
											<!--Логин-->
											<td><?= $row['login']; ?></td>
											<td><?= $row['image_url']; ?></td>
											<!--Доступ-->
											<td id='access_<?= $row['id']; ?>'><?= ($row['access'] ? "есть" : "нет"); ?></td>
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
												<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
													<span class="btn btn-primary btn-sm">действие</span>
													<div class="btn-group" role="group">
														<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
														<div id="dropdown_<?= $row['id']; ?>" class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
															<span class="dropdown-item" onclick="operation(<?= $row['id']; ?>, 'resetPassword');">Сбросить пароль</span>
															<span class="dropdown-item" onclick="operation(<?= $row['id']; ?>, '<?= ($row['access'] ? "blockUser" : "unlockUser") ?>');">
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
<script>
	function operation(id, typeOperation) {
		var dataString = 'id=' + id + '&type_operation=';
		switch (typeOperation) {
			case 'resetPassword':
				dataString += typeOperation;
				break;
			case 'blockUser':
				dataString += typeOperation;
				break;
			case 'unlockUser':
				dataString += typeOperation;
				break;
		}

		$.ajax({
			url: "/user/operation",
			type: "POST",
			dataType: "json",
			data: dataString,
			cache: false,
			success: function(dad) {
				if (dad.error === 1) {
					alert(dad.message);
				} else {
					alert(dad.message.toString());
					if (typeOperation != 'resetPassword') {
						var text = (typeOperation == 'blockUser') ? 'нет' : 'есть';
						if (dad.use_elem) {
							$('#dropdown_' + id).html(dad.elem);
							$('#access_' + id).html(text);
						}

					}
				}
			},
			error: function(er) {
				console.log(er);
			}
		});

	}
</script>