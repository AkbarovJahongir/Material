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
													<th><?= $language_["KOA"] ?></th>
													<th><?= $language_["SCOPUS"] ?></th>
													<th><?= $language_["RINSE"] ?></th>
													<th><?= $language_["international"] ?></th>
													<th><?= $language_["republic"] ?></th>
													<th><?= $language_["total"] ?></th>
												</tr>
											</thead>
											<tbody>

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
				url: '/report/getreportArticle',
				type: 'POST',
				data: { kafedra_id: kafedraId },
				success: function (response) {
					//kafedraSelect.empty();

					if (typeof response === 'string') {
						try {
							response = JSON.parse(response);
						} catch (e) {
							console.error("Parsing error:", e);
							return;
						}
					}

					if (response.error) {
						openModals(name);  // Display the error message
					} else {
						fillTable(response);
					}
				},
				error: function (xhr, status, error) {
					console.error("AJAX error: ", status, error);  // Log AJAX errors
				}
			});
		});
	});

function fillTable(data) {
    var tableBody = $('#sampleTable tbody');
    tableBody.empty();  // Clear the table body

    $.each(data, function (index, user) {
        var row = '<tr>';
        row += '<td class="cut-text">' + user.row_number + '</td>';
        row += '<td class="cut-text"><a href="#" onclick="openModals(\'' + user.name + '\')" </a>'+ user.name +'</td>';
        row += '<td class="cut-text">' + user.KOA + '</td>';
        row += '<td class="cut-text">' + user.SCOPUS + '</td>';
        row += '<td class="cut-text">' + user.РИНС + '</td>';
        row += '<td class="cut-text">' + user.Байналмилалӣ + '</td>';
        row += '<td class="cut-text">' + user.Чумхурияви + '</td>';
        row += '<td class="cut-text">' + user.total_count + '</td>';
        row += '</tr>';
        tableBody.append(row);
    });
}
	$('#faculty').select2();
	$('#kafedra').select2();  
	function openModals(name) {
		$('#description').val(name);
		swal("", name, "");
	}
</script>