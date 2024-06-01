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
</style>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title"><?= $language_["reportonPublish"] ?></h3>
            <div class="tile-body">
                <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile-body">
                                <div style="width: 100%; float:left;">
                                    <canvas id="publicationChart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="row">
                                    <div class="col-4">
                                        <h3 class="tile-title"><?= $language_["addedMaterial"] ?></h3>
                                    </div>
                                    <label class="control-label col-md-2 text-right"><?= $language_["selectedKafedra"] ?>*:</label>
                                    <div class="col-6">
                                        <select name="kafedra" id="kafedra" class="form-control">
                                            <option value='0'><?= $language_["all"] ?></option>
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
                                <br />
                                <div class="row">
                                    <div class="col-12">
                                        <div style="width: 80%; margin: auto;">
                                            <canvas id="publicationChart2"></canvas>
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
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <h3 class="tile-title"><?= $language_["analizData"] ?></h3>
                                <div style="width: 80%; margin: auto;">
                                    <canvas id="activityChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="row">
                                    <div class="col-4">
                                        <h3 class="tile-title"><?= $language_["addedMaterial"] ?></h3>
                                    </div>
                                    <label class="control-label col-md-2 text-right"><?= $language_["selectedUser"] ?>*:</label>
                                    <div class="col-6">
                                        <select name="users" id="users" class="form-control">
                                            <option value='0'><?= $language_["all"] ?></option>
                                            <?php
                                            if (isset($data["users"])) {
                                                foreach ($data['users'] as $row) {
                                                    echo "<option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-12">
                                        <div style="width: 80%; margin: auto;">
                                            <canvas id="materialsChart"></canvas>
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
</div>
<script type="text/javascript" src="/assets/js/plugins/select2.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>
<script>
    function fetchDataAndDrawChart() {
        $.ajax({
            url: "/report/getFaculty",
            type: "POST",
            dataType: "json",
            cache: false,
            success: function (response) {
                if (response && !response.error && response.length > 0) {
                    const userData1 = {
                        labels: response.map(entry => entry.name),
                        datasets: [{
                            label: '<?= $language_["countMaterial"] ?>',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            data: response.map(entry => entry.count)
                        }]
                    };

                    const ctx1 = document.getElementById('publicationChart1').getContext('2d');
                    const publicationChart1 = new Chart(ctx1, {
                        type: 'bar',
                        data: userData1,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                } else {
                    swal("<?= $language_["error"] ?>!", response.message || "Нет данных для отображения", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr, status, error);
                swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
            }
        });
    }

    function drawFixedChart() {
    var kafedra = document.getElementById('kafedra').value;
    //alert(kafedra);
    $.ajax({
        url: "/report/getKafedra",
        type: "POST",
        dataType: "json",
        data: "kafedra=" + kafedra,
        cache: false,
        success: function (response) {
            if (response && !response.error) {
                console.log(response);
                const userData = {
                    labels: response.map(entry => entry.year),
                    datasets: [{
                        label: '<?= $language_["addedMaterial"] ?>',
                        data: response.map(entry => entry.count),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: true // Добавляем параметр fill для заполнения области под графиком
                    }]
                };

                const ctx = document.getElementById('publicationChart2').getContext('2d');
                if (window.publicationChart2 instanceof Chart) {
                    window.publicationChart2.destroy();
                }
                window.publicationChart2 = new Chart(ctx, {
                    type: 'line', // Меняем тип графика на 'line' для отображения областей
                    data: userData,
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            } else {
                swal("Данные отсутствуют!", response.message || "Нет данных для отображения", "error");
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr, status, error);
            swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
        }
    });
}


    function drawDataAnalysisChart() {
        $.ajax({
            url: "/report/getAllByYear",
            type: "POST",
            dataType: "json",
            cache: false,
            success: function (response) {
                if (response && !response.error) {

                    const userActivityData = {
                        labels: response.map(entry => entry.year),
                        datasets: [{
                            label: '<?= $language_["activity"] ?>',
                            data: response.map(entry => entry.count),
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    };

                    const ctx = document.getElementById('activityChart').getContext('2d');
                    const activityChart = new Chart(ctx, {
                        type: 'bar',
                        data: userActivityData,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                } else {
                    swal("<?= $language_["error"] ?>!", response.message || "Нет данных для отображения", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr, status, error);
                swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
            }
        });
    }


    function drawDataUsersChart() {
        var users = document.getElementById('users').value;
        $.ajax({
            url: "/report/getUsers",
            type: "POST",
            dataType: "json",
            data: "users=" + users,
            cache: false,
            success: function (response) {
                if (response && !response.error) {
                    console.log(response);
                    const userData = {
                        labels: response.map(entry => entry.year),
                        datasets: [{
                            label: '<?= $language_["addedMaterial"] ?>',
                            data: response.map(entry => entry.count),
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    };

                    const ctx = document.getElementById('materialsChart').getContext('2d');
                    if (window.materialsChart instanceof Chart) {
                        window.materialsChart.destroy();
                    }
                    window.materialsChart = new Chart(ctx, {
                        type: 'bar',
                        data: userData,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                } else {
                    swal("Данные отсутствуют!", response.message || "Нет данных для отображения", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr, status, error);
                swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>!", "error");
            }
        });
    }
    $('#users').select2();

    $('#users').change(function () {
        drawDataUsersChart();
    });
    $('#kafedra').select2();

    $('#kafedra').change(function () {
        drawFixedChart();
    });
    $(document).ready(function () {
        fetchDataAndDrawChart();
        drawFixedChart();
        drawDataAnalysisChart();
        drawDataUsersChart();
    });
</script>