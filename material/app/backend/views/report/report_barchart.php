<style>
    span.dropdown-item {
        cursor: pointer;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Отчет по публикациям</h3>
            <div class="tile-body">
                <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile-body">
                                <div style="width: 60%; float:left;">
                                    <canvas id="publicationChart1"></canvas>
                                </div>
                                <div style="width: 30%; float:inline-end;">
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
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <h3 class="tile-title">Анализ данных</h3>
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
                                        <h3 class="tile-title">Добавлены материалы</h3>
                                    </div>
                                    <label class="control-label col-md-2 text-right">Выбрать пользователя*:</label>
                                    <div class="col-6">
                                        <select name="users" id="users" class="form-control">
                                            <option value='0'>Все</option>
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
                            label: 'Количество материалов',
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
                    swal("ОШИБКА!", response.message || "Нет данных для отображения", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr, status, error);
                swal("ОШИБКА!", "Что-то пошло не так!", "error");
            }
        });
    }

    function drawFixedChart() {
        $.ajax({
            url: "/report/getKafedra",
            type: "POST",
            dataType: "json",
            cache: false,
            success: function (response) {
                if (response && !response.error && response.length > 0) {
                    const userData2 = {
                        labels: response.map(entry => entry.name),
                        datasets: [{
                            label: 'Количество материалов',
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1,
                            data: response.map(entry => entry.count)
                        }]
                    };
                    const ctx2 = document.getElementById('publicationChart2').getContext('2d');
                    const publicationChart2 = new Chart(ctx2, {
                        type: 'doughnut',
                        data: userData2
                    });
                } else {
                    swal("ОШИБКА!", response.message || "Нет данных для отображения", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr, status, error);
                swal("ОШИБКА!", "Что-то пошло не так!", "error");
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
                            label: 'Активность',
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
                    swal("ОШИБКА!", response.message || "Нет данных для отображения", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr, status, error);
                swal("ОШИБКА!", "Что-то пошло не так!", "error");
            }
        });
    }


    function drawDataUsersChart() {
    var users =  document.getElementById('users').value;
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
                        label: 'Добавлены материалы',
                        data: response.map(entry => entry.count),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                };

                const ctx = document.getElementById('materialsChart').getContext('2d');
                if(window.materialsChart instanceof Chart){
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
                swal("ОШИБКА!", response.message || "Нет данных для отображения", "error");
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr, status, error);
            swal("ОШИБКА!", "Что-то пошло не так!", "error");
        }
    });
}


    $('#users').change(function(){
        drawDataUsersChart();
    });
    $(document).ready(function () {
        fetchDataAndDrawChart();
        drawFixedChart();
        drawDataAnalysisChart();
        drawDataUsersChart();
    });
</script>