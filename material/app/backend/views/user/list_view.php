<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
	$language_ = [];
	include_once './app/language/Users/languageRU.php';
	$language_ = $language;
} else {
	$language_ = [];
	include_once './app/language/Users/languageTJ.php';
	$language_ = $language;
}
?>
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>

<style>
	span.dropdown-item {
		cursor: pointer;
	}
</style>
<div class="app-title">
	<div>
		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="/user"><?= $language_["users"] ?></a></li>
		</ul>
	</div>
	<a class="btn btn-primary btn-sm" href="/user/add/"><?= $language_["add"] ?></a>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<h3 class="tile-title"><?= $language_["listOfUsers"] ?></h3>
			<div class="tile-body">
				<div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
					<div class="row">
						<div class="col-12">
							<div class="table-responsive">
								<table class="table table-hover table-bordered dataTable no-footer" id="sampleTable"
									role="grid" aria-describedby="sampleTable_info">
									<thead>
										<tr role="row">
											<th style="width: 25px;">ID</th>
											<th style="width: 100px;"><?= $language_["name"] ?></th>
											<th style="width: 100px;"><?= $language_["role"] ?></th>
											<th style="width: 100px;"><?= $language_["login"] ?></th>
											<th style="width: 100px;"><?= $language_["faculty"] ?></th>
											<th style="width: 100px;"><?= $language_["department"] ?></th>
											<th style="width: 100px;"><?= $language_["photo"] ?></th>
											<th style="width: 20px;"><?= $language_["access"] ?></th>
											<th style="width: 70px;"></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($data['users'] as $row): ?>
											<tr role='row'>
												<td><?= $row['id']; ?></td>
												<td><a href='/user/edit/<?= $row['id']; ?>'><?= $row['name']; ?></a></td>
												<td><?= $row['role_name']; ?></td>
												<td><?= $row['login']; ?></td>
												<td><?= $row['faculty']; ?></td>
												<td><?= $row['kafedra']; ?></td>
												<td><?= $row['image_url']; ?></td>
												<td id='access_<?= $row['id']; ?>'>
													<?= ($row['access'] ? $language_["accessYes"] : $language_["accessNo"]); ?>
												</td>
												<td>
													<div class='btn-group'>
														<a href='/user/edit/<?= $row['id']; ?>'
															class='btn btn-primary btn-sm'><i
																class='fa fa-lg fa-edit'></i></a>
													</div>
													<div class="btn-group" role="group"
														aria-label="Button group with nested dropdown">
														<span
															class="btn btn-primary btn-sm"><?= $language_["action"] ?></span>
														<div class="btn-group" role="group">
															<button class="btn btn-primary btn-sm dropdown-toggle"
																type="button" data-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false"></button>
															<div id="dropdown_<?= $row['id']; ?>"
																class="dropdown-menu dropdown-menu-right"
																x-placement="bottom-end"
																style="width: max-content; white-space: nowrap;">
																<span class="dropdown-item"
																	onclick="openModal(<?= $row['id'] ?>)"><?= $language_["resetThePassword"] ?></span>
																<span class="dropdown-item"
																	onclick="operation(<?= $row['id']; ?>, '<?= ($row['access'] ? "blockUser" : "unlockUser") ?>');"><?= ($row['access'] ? $language_["block"] : $language_["unlockUser"]) ?></span>
															</div>

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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel"><?= $language_["passwordUpdate"] ?></h3>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<form class="form-horizontal" style="margin-top: 20px;">
						<input id="Language" type="hidden" />
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label id="name" class="col-md-12" for="name"><?= $language_["user"] ?></label>
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
										<label class="col-md-12" for="comment"><?= $language_["newPassword"] ?></label>
										<div class="col-md-12">
											<input name="password" id="password" class="form-control" type="password"
												placeholder="<?= $language_["enterPassword"] ?>">
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
					data-dismiss="modal"><?= $language_["update"] ?></button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $language_["close"] ?></button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>
<script>
	$('#sampleTable').DataTable({
        language:{           
            url: '<?=$_SESSION['local']?>'=='tj'?'/assets/json/tg.json':'/assets/json/ru.json',
        }
    });
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
			cancelButtonText: "<?= $language_["rejectEdit"] ?>",
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
				swal("<?= $language_["canceled"] ?>!", "Вы чуть не " + messages + " доступ пользователя :)", "error");
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
			cancelButtonText: "<?= $language_["rejectEdit"] ?>",
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
							swal("<?= $language_["error"] ?>!", response.message, "error");
							console.log(id);
						} else {
							swal("Успешно!", response.message, "success");
							location.reload();
						}
					},
					error: function (er) {
						console.log(er);
						swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
					}
				});
			} else {
				swal("<?= $language_["canceled"] ?>!", "Вы чуть не сбросили пароль :)", "error");
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
					swal("<?= $language_["error"] ?>!", "Пользователь не найден!", "error");
				}
			},
			error: function (err) {
				console.log(err);
				swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
			}
		});
	}
</script>