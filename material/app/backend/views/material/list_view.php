<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
	$language_ = [];
	include_once './app/language/Material/languageRU.php';
	$language_ = $language;
} else {
	$language_ = [];
	include_once './app/language/Material/languageTJ.php';
	$language_ = $language;
}
?>
<style>
	span.dropdown-item {
		cursor: pointer;
	}

	.modal {
		display: none;
		/* Стили модального окна */
	}
</style>
<div class="app-title">
	<div>
		<ul class="app-breadcrumb breadcrumb">
			<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
			<li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>"><?= $language_["materials"] ?></a>
			</li>
		</ul>
	</div>
	<?php if ($_SESSION["uid"]["role_id"] == 2 || $_SESSION["uid"]["role_id"] == 1) {
		echo '
	<a class="btn btn-primary btn-sm" href=' . $data['controller_name'] . '/add/">' . $language_["add"] . '</a>';
	} ?>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<?php
			if (isset($data["message"])) {
				echo '<div id="messageBlock" class="card text-black bg-light"><div class="card-body">' . $data["message"] . '</div></div><br>';
			}
			?>
			<h3 class="tile-title"><?= $language_["allScientificMaterials"] ?></h3>
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
													<th><?= $language_["name"] ?></th>
													<th><?= $language_["authors"] ?></th>
													<th><?= $language_["typeOfScientific"] ?></th>
													<th><?= $language_["conferenceTitle"] ?></th>
													<th><?= $language_["magazineName"] ?></th>
													<th><?= $language_["directionOfScientificMaterial"] ?></th>
													<th><?= $language_["urls"] ?></th>
													<th><?= $language_["faculty"] ?></th>
													<th><?= $language_["department"] ?></th>
													<th><?= $language_["publicationDate"] ?></th>
													<th><?= $language_["status"] ?></th>
													<th><?= $language_["comment"] ?></th>
													<?php
													if (
														($_SESSION["uid"]["role_id"] == 2) ||
														($_SESSION["uid"]["role_id"] != 1) ||
														($_SESSION["uid"]["role_id"] == 4)
													) {
														echo '<th style="height: 10px;">' . $language_["action"] . '</th>';
													} else if ($_SESSION["uid"]["role_id"] == 1) {
														echo '<th style="height: 10px;">' . $language_["action"] . '</th>';
													}
													?>
													<th><?= $language_["file"] ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data['materials'] as $material): ?>
													<tr>
														<td><?= $material['id'] ?></td>
														<td class="material-cell"data-name="<?= htmlspecialchars($material['name']) ?>">
															<?php
															$name = htmlspecialchars($material['name'], ENT_QUOTES, 'UTF-8');
															echo '<a href="#" onclick="openModals(\'' . $name . '\')">' . mb_substr($name, 0, 20) . '</a>';
															?>
														</td>
														<td class="material-cell"data-name="<?= htmlspecialchars($material['authors']) ?>">
															<?php
															$name = htmlspecialchars($material['authors'], ENT_QUOTES, 'UTF-8');
															echo '<a href="#" onclick="openModals(\'' . $name . '\')">' . mb_substr($name, 0, 20) . '</a>';
															?>
														</td>

														<td><?= $material['type'] ?></td>

														<td class="material-cell"data-name="<?= $material['conference_name'] ?>">
															<?php
															$name = htmlspecialchars($material['conference_name'], ENT_QUOTES, 'UTF-8');
															echo '<a href="#" onclick="openModals(\'' . $name . '\')">' . mb_substr($name, 0, 20) . '</a>';
															?>
														</td>
														<td class="material-cell" data-name="<?= $material['name_jurnal'] ?>">
															<?php
															$name = htmlspecialchars($material['name_jurnal'], ENT_QUOTES, 'UTF-8');
															echo '<a href="#" onclick="openModals(\'' . $name . '\')">' . mb_substr($name, 0, 20) . '</a>';
															?>
														</td>
														<td class="material-cell" data-name="<?= $material['direction'] ?>">
															<?php
															$name = htmlspecialchars($material['direction'], ENT_QUOTES, 'UTF-8');
															echo '<a href="#" onclick="openModals(\'' . $name . '\')">' . mb_substr($name, 0, 20) . '</a>';
															?>
														</td>
														<td class="material-cell" data-name="<?= $material['url'] ?>">
															<?php
															$name = htmlspecialchars($material['url'], ENT_QUOTES, 'UTF-8');
															echo '<a href="#" onclick="openModals(\'' . $name . '\')">' . mb_substr($name, 0, 20) . '</a>';
															?>
														</td>
														<td><?= $material['faculty'] ?></td>
														<td class="material-cell"data-name="<?= $material['kafedra'] ?>">
															<?php
															$name = htmlspecialchars($material['kafedra'], ENT_QUOTES, 'UTF-8');
															echo '<a href="#" onclick="openModals(\'' . $name . '\')">' . mb_substr($name, 0, 20) . '</a>';
															?>
														</td>
														<td><?= $material['date_publish'] ?></td>
														<td><?= $material['status'] ?></td>
														<td><?= $material['comment'] ?></td>
														<?php if ($_SESSION["uid"]["role_id"] == 1): ?>
															<td>
																<div class="btn-group">
																	<a href="/<?= $data['controller_name'] ?>/edit/<?= $material['id'] ?>"
																		class="btn btn-primary btn-sm"><i
																			class="fa fa-lg fa-edit"></i>
																		<?= $language_["change"] ?></a>
																</div>
																<div
																	style="display:flex;justify-content:space-around;padding: 5px;">
																	<div class="btn-group">
																		<a href="#"
																			onclick="deleteMaterial(<?= $material['id'] ?>)"
																			class="btn btn-danger btn-sm del-material"><i
																				class="fa fa-lg fa-trash"></i>
																			<?= $language_["delete"] ?></a>
																	</div>
																</div>
															</td>
														<?php elseif (
															($_SESSION["uid"]["role_id"] == 2 && $material["status_id"] == 1 && $material["status_id"] != 2) ||
															($_SESSION["uid"]["role_id"] == 4 && $material["status_id"] != 1 && $material["status_id"] == 2)
														): ?>
															<td>
																<div
																	style="display: flex; justify-content: space-around; padding: 5px;">
																	<div class="btn-group">
																		<a href="/<?= $data['controller_name'] ?>/confirm/<?= $material['id'] ?>"
																			class="btn btn-primary btn-sm">
																			<i class="fa fa-lg fa-edit"></i>
																			<?= $language_["confirm"] ?>
																		</a>
																	</div>
																	<div class="btn-group">
																		<a href="#" onclick="openModal(<?= $material['id'] ?>)"
																			class="btn btn-danger btn-sm del-material">
																			<i class="fa fa-lg fa-trash"></i>
																			<?= $language_["reject"] ?>
																		</a>
																	</div>
																</div>
															</td>
														<?php else: ?>
															<td><?= $language_["materialBeingProcessed"] ?></td>
														<?php endif; ?>
														<td>
															<div class="btn-group">
																<?php if (!empty($material['file_path'])): ?>
																	<a href="/app/uploads/file/<?= $material['file_path'] ?>"
																		class="btn btn-primary btn-sm" target="_blank">
																		<i class="fa fa-lg fa-book"></i>
																		<?= $language_["download"] ?>
																	</a>
																<?php else: ?>
																	<p><?= $language_["fileMissing"] ?></p>
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
				<h3 class="modal-title" id="exampleModalLabel"><?= $language_["addingaComment"] ?></h3>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<form class="form-horizontal" style="margin-top: 20px;">
						<input id="Language" type="hidden" />
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label id="name" class="col-md-12"
											for="name"><?= $language_["scientificMaterial"] ?></label>
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
										<label class="col-md-12" for="comment"><?= $language_["comment"] ?></label>
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
				<button type="button" id="submit" onclick="declineMaterial(<?php $material['id'] ?>)"
					style="background-color:limegreen; color:white" class="btn btn-secondary"
					data-dismiss="modal"><?= $language_["reject"] ?></button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $language_["close"] ?></button>
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

	$('#sampleTable').DataTable({
		language: {
			url: '<?= $_SESSION['local'] ?>'=='tj'?'/as   s ets/json/tg.json':'/assets/json/ru.json',
		}
	});

	function deleteMaterial(id) {
		swal({
			title: "Вы действительно хотите удалить?",
			text: "ВАЖНО! Вы не сможете удалить тех кто уже связаны матералами",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "ДА, удалить!",
			cancelButtonText: "<?= $language_["rejectEdit"] ?>",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function (isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: "/material/delete",
					type: "POST",
					dataType: "json",
					data: "id=" + id,
					cache: false,
					success: function (response) {
						if (response.error === 1) {
							swal("<?= $language_["error"] ?>!", response.message, "error");
							console.log(id);
						} else {
							swal("УДАЛЕНО!", response.message, "success");
							location.reload();
						}
					},
					error: function (er) {
						console.log(er);
						swal("<?= $language_["error"] ?>!", "Что то пошло не так!", "error");
					}
				});
			} else {
				swal("<?= $language_["canceled"] ?>!", "Вы чуть не удалили :)", "error");
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
			success: function (response) {
				console.log(response);
				if (response && !response.error) {
					$id = id;
					$('#nameMaterial').val(response["name"]);
				} else {
					console.log("Материал с идентификатором не найден: " + id);
					swal("<?= $language_["error"] ?>!", "Материал не найден!", "error");
				}
			},
			error: function (err) {
				console.log(err);
				swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
			}
		});
		$('#myModal').modal('show');
	}

	function openModals(name) {
		$('#description').val(name);
		swal("", name, "");
		//$('#myModals').modal('show');
	}
	function declineMaterial() {
		var $ID = $id;
		var $comment = $("#comment").val();
		swal({
			title: "Вы действительно хотите отклонить?",
			text: "ВАЖНО! Отклоненный материал будет обратно отправлен пользователю который добавил его",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "ДА, отклонить!",
			cancelButtonText: "<?= $language_["rejectEdit"] ?>",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function (isConfirm) {
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
					success: function (response) {
						if (response.error === 1) {
							swal("<?= $language_["error"] ?>!", response.message, "error");
							console.log(id);
						} else {
							swal("Откланено!", response.message, "success");
							location.reload();
						}
					},
					error: function (er) {
						console.log(er);
						swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
					}
				});
			} else {
				swal("<?= $language_["canceled"] ?>!", "Вы чуть не отклонили :)", "error");
			}
		});
		$id = '';
		$("#comment").val('');
	}
	var delayBeforeClose = 3000;
	function closeMessage() {
		var messageBlock = document.getElementById('messageBlock');
		if (messageBlock) {
			messageBlock.style.display = 'none'; // Скрыть блок сообщения
		}
	}

	setTimeout(closeMessage, delayBeforeClose);
 
</script>