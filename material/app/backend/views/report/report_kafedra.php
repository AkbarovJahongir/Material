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

	.cut-text {
		max-width: 150px;
		/* Set the maximum width you prefer */
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;

	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="tile">
			<?php
			if (isset($data["message"])) {
				echo '<div id="messageBlock" class="card text-black bg-light"><div class="card-body">' . $data["message"] . '</div></div><br>';
			}
			?>

			<h3 class="tile-title"><?= $language_["allScientificMaterialsReport"] ?></h3>
			<div class="tile-body">
				<div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
					<div class="row">
						<div class="col-md-12">
							<div class="tile">
								<div class="tile-body">
									<div class="form-group row">
										<label
											class="control-label col-md-2 text-right"><?= $language_["selectedFaculty"] ?>*:</label>
										<div class="col-md-3">
											<select name="faculty" id="faculty" class="form-control">
												<option value='0'><?= $language_["all"] ?></option>
												<?php
												if (isset($data["faculty"])) {
													foreach ($data['faculty'] as $row) {
														echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
													}
												}
												?>
											</select>
										</div>
										<label
											class="control-label col-md-2 text-right"><?= $language_["selectedKafedra"] ?>*:</label>
										<div class="col-md-3">
											<select name="kafedra" id="kafedra" class="form-control">
												<!-- <option value='0'><?= $language_["all"] ?></option> -->
												<?php
												if (isset($data["kafedra"])) {
													foreach ($data['kafedra'] as $row) {
														echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
													}
												}
												?>
											</select>
										</div>
									</div>
									<div class="table-responsive">
										<table class="table table-hover table-bordered" id="sampleTable">
											<thead class="thead">
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
													<th><?= $language_["user_k"] ?></th>
													<th><?= $language_["user_d"] ?></th>
													<th><?= $language_["comment"] ?></th>
													<th><?= $language_["action"] ?></th>
													<th><?= $language_["file"] ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data['materials'] as $material): ?>
													<tr>
														<td><?= $material['id'] ?></td>
														<td class="cut-text">
															<a href="#"
																onclick="openModals('<?= htmlspecialchars($material['name'], ENT_QUOTES, 'UTF-8') ?>')"><?= htmlspecialchars($material['name'], ENT_QUOTES, 'UTF-8') ?></a>
														</td>
														<td class="cut-text">
															<a href="#"
																onclick="openModals('<?= htmlspecialchars($material['authors'], ENT_QUOTES, 'UTF-8') ?>')"><?= htmlspecialchars($material['authors'], ENT_QUOTES, 'UTF-8') ?></a>
														</td>
														<td><?= $material['type'] ?></td>
														<td class="cut-text">
															<a href="#"
																onclick="openModals('<?= htmlspecialchars($material['conference_name'], ENT_QUOTES, 'UTF-8') ?>')"><?= htmlspecialchars($material['conference_name'], ENT_QUOTES, 'UTF-8') ?></a>
														</td>
														<td class="cut-text">
															<a href="#"
																onclick="openModals('<?= htmlspecialchars($material['name_jurnal'], ENT_QUOTES, 'UTF-8') ?>')"><?= htmlspecialchars($material['name_jurnal'], ENT_QUOTES, 'UTF-8') ?></a>
														</td>
														<td class="cut-text">
															<a href="#"
																onclick="openModals('<?= htmlspecialchars($material['direction'], ENT_QUOTES, 'UTF-8') ?>')"><?= htmlspecialchars($material['direction'], ENT_QUOTES, 'UTF-8') ?></a>
														</td>
														<td class="cut-text">
															<a href="#"
																onclick="openModals('<?= htmlspecialchars($material['url'], ENT_QUOTES, 'UTF-8') ?>')"><?= htmlspecialchars($material['url'], ENT_QUOTES, 'UTF-8') ?></a>
														</td>
														<td><?= $material['faculty'] ?></td>
														<td class="cut-text">
															<a href="#"
																onclick="openModals('<?= htmlspecialchars($material['kafedra'], ENT_QUOTES, 'UTF-8') ?>')"><?= htmlspecialchars($material['kafedra'], ENT_QUOTES, 'UTF-8') ?></a>
														</td>
														<td><?= $material['date_publish'] ?></td>
														<td class="cut-text">
															<a href="#"
																onclick="openModals('<?= htmlspecialchars($material['status'], ENT_QUOTES, 'UTF-8') ?>')"><?= htmlspecialchars($material['status'], ENT_QUOTES, 'UTF-8') ?></a>
														</td>
														<td><?= $material["user_k"] ?></td>
														<td><?= $material["user_d"] ?></td>
														<td><?= $material['comment'] ?></td>
														<td>
															<?php if ($_SESSION["uid"]["role_id"] == 1): ?>
																<div class="btn-group">
																	<a href="/<?= $data['controller_name'] ?>/edit/<?= $material['id'] ?>"
																		class="btn btn-primary btn-sm">
																		<i class="fa fa-lg fa-edit"></i>
																		<?= $language_["change"] ?>
																	</a>
																	<a href="#" onclick="deleteMaterial(<?= $material['id'] ?>)"
																		class="btn btn-danger btn-sm del-material">
																		<i class="fa fa-lg fa-trash"></i>
																		<?= $language_["delete"] ?>
																	</a>
																</div>
															<?php elseif (
																($_SESSION["uid"]["role_id"] == 2 && $material["status_id"] == 1 && $material["status_id"] != 2) ||
																($_SESSION["uid"]["role_id"] == 4 && $material["status_id"] != 1 && $material["status_id"] == 2)
															): ?>
																<div class="btn-group">
																	<a href="/<?= $data['controller_name'] ?>/confirm/<?= $material['id'] ?>"
																		class="btn btn-primary btn-sm">
																		<i class="fa fa-lg fa-edit"></i>
																		<?= $language_["confirm"] ?>
																	</a>
																	<a href="#" onclick="openModal(<?= $material['id'] ?>)"
																		class="btn btn-danger btn-sm del-material">
																		<i class="fa fa-lg fa-trash"></i>
																		<?= $language_["reject"] ?>
																	</a>
																</div>
															<?php else: ?>
																<?= $language_["materialBeingProcessed"] ?>
															<?php endif; ?>
														</td>
														<td>
															<?php if (!empty($material['file_path'])): ?>
																<a href="/app/uploads/file/<?= $material['file_path'] ?>"
																	class="btn btn-primary btn-sm" target="_blank">
																	<i class="fa fa-lg fa-book"></i>
																	<?= $language_["download"] ?>
																</a>
															<?php else: ?>
																<p><?= $language_["fileMissing"] ?></p>
															<?php endif; ?>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div> <!-- End table-responsive -->
								</div> <!-- End tile-body -->
							</div> <!-- End tile -->
						</div> <!-- End col-md-12 -->
					</div> <!-- End row -->
				</div> <!-- End dataTables_wrapper -->
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/assets/js/plugins/select2.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>
<script type="text/javascript">
	// Function to get the current date and time in a specific format
	function getFormattedDateTime() {
		var now = new Date();
		var year = now.getFullYear();
		var month = ('0' + (now.getMonth() + 1)).slice(-2);
		var day = ('0' + now.getDate()).slice(-2);
		var hours = ('0' + now.getHours()).slice(-2);
		var minutes = ('0' + now.getMinutes()).slice(-2);
		var seconds = ('0' + now.getSeconds()).slice(-2);
		return year + '-' + month + '-' + day + '_' + hours + '-' + minutes + '-' + seconds;
	}
	$(document).ready(function () {
		$('#sampleTable').DataTable({
			dom: 'lBfrtip',
			buttons: [
				{
					extend: 'excel',
					filename: function () {
						return 'Корхо илмӣ ' + getFormattedDateTime();
					}
				},
				{
					extend: 'copy',
					filename: function () {
						return 'Корхо илмӣ ' + getFormattedDateTime();
					}
				},
				{
					extend: 'print',
					title: function () {
						return 'Корхо илмӣ ' + getFormattedDateTime();
					}
				}
			],
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			language: {
				url: '<?= $_SESSION['local'] == 'tj' ? '/assets/json/tg.json' : '/assets/json/ru.json' ?>'
			},
		});
		// $('#faculty').change(function() {
		//     var facultyId = $(this).val();
		//     $.ajax({
		//         url: "/report/getKafedraByIdFaculty",
		//         type: 'POST',
		//         data: {faculty_id: facultyId},
		//         success: function(response) {
		//             var kafedraSelect = $('#kafedra');
		//             kafedraSelect.empty();
		//             kafedraSelect.append("<option value='0'><?= $language_["all"] ?></option>");
		//             $.each(JSON.parse(response), function(index, kafedra) {
		// 				console.log(kafedra);
		//                 kafedraSelect.append("<option value='" + kafedra.id + "'>" + kafedra.name + "</option>");
		//             });
		//         }
		//     });
		// });
		$('#faculty').change(function () {
			var facultyId = $(this).val();
			$.ajax({
				url: '/report/getKafedraByIdFaculty',
				type: 'POST',
				data: { faculty_id: facultyId },
				success: function (response) {
					//console.log("Raw response:", response);  // Log the raw response
					var kafedraSelect = $('#kafedra');
					kafedraSelect.empty();
					kafedraSelect.append("<option value='0'><?= $language_["all"] ?></option>");

					if (typeof response === 'string') {
						try {
							response = JSON.parse(response);
						} catch (e) {
							console.error("Parsing error:", e);
							return;
						}
					}

					if (response.error) {
						//alert(response.message);  // Display the error message
					} else {
						$.each(response, function (index, kafedra) {
							kafedraSelect.append("<option value='" + kafedra.id + "'>" + kafedra.name + "</option>");
						});
					}
				},
				error: function (xhr, status, error) {
					console.error("AJAX error: ", status, error);  // Log AJAX errors
				}
			});
		});
		$('#kafedra').change(function () {
			var kafedraId = $(this).val();
			$.ajax({
				url: '/report/getKafedraByIdFaculty',
				type: 'POST',
				data: { kafedra_id: kafedraId },
				success: function (response) {
					//console.log("Raw response:", response);  // Log the raw response
					var kafedraSelect = $('#kafedra');
					kafedraSelect.empty();
					kafedraSelect.append("<option value='0'><?= $language_["all"] ?></option>");

					if (typeof response === 'string') {
						try {
							response = JSON.parse(response);
						} catch (e) {
							console.error("Parsing error:", e);
							return;
						}
					}

					if (response.error) {
						//alert(response.message);  // Display the error message
					} else {
						$.each(response, function (index, kafedra) {
							kafedraSelect.append("<option value='" + kafedra.id + "'>" + kafedra.name + "</option>");
						});
					}
				},
				error: function (xhr, status, error) {
					console.error("AJAX error: ", status, error);  // Log AJAX errors
				}
			});
		});
	});


	$('#faculty').select2();
	$('#kafedra').select2();
	function openModals(name) {
		$('#description').val(name);
		swal("", name, "");
		//$('#myModals').modal('show');
	}
</script>