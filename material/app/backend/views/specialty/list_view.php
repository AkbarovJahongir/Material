<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
    $language_ = [];
    include_once './app/language/Specialty/specialtyLanguageRU.php';
    $language_ = $language;
} else {
    $language_ = [];
    include_once './app/language/Specialty/specialtyLanguageTJ.php';
    $language_ = $language;
}
?>
<style>
    span.dropdown-item {
        cursor: pointer;
    }
</style>
<div class="app-title">
    <div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>"><?= $language_["specialties"] ?></a></li>
        </ul>
    </div>
    <a class="btn btn-primary btn-sm" href="/<?= $data['controller_name'] ?>/add/"><?= $language_["add"] ?></a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title"><?= $language_["allSpecialties"] ?></h3>
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
                                                    <th><?= $language_["code"] ?></th>
                                                    <th><?= $language_["speciality"] ?></th>
                                                    <th><?= $language_["action"] ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['specialties'] as $specialty) : ?>
                                                    <tr>
                                                        <td><?= $specialty['code'] ?></td>
                                                        <td><?= $specialty['name'] ?></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="/<?= $data['controller_name'] ?>/edit/<?= $specialty['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-lg fa-edit"></i> <?= $language_["change"] ?></a>
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

<!-- Page specific javascripts-->
<script type="text/javascript" src="/assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable({  
        language:{           
            url: '<?=$_SESSION['local']?>'=='tj'?'/assets/json/tg.json':'/assets/json/ru.json',
        }
    });
    var delayBeforeClose = 3000; // Например, 3000 миллисекунд = 3 секунды

	// Функция для закрытия сообщения
	function closeMessage() {
		var messageBlock = document.getElementById('messageBlock');
		if (messageBlock) {
			messageBlock.style.display = 'none'; // Скрыть блок сообщения
		}
	}

	// Запуск функции closeMessage() через указанное время
	setTimeout(closeMessage, delayBeforeClose);
</script>