<?php
$language_ = [];
if ($_SESSION["local"] == "ru") {
    $language_ = [];
    include_once './app/language/Author/authorLanguageRU.php';
    $language_ = $language;
} else {
    $language_ = [];
    include_once './app/language/Author/authorLanguageTJ.php';
    $language_ = $language;
}
?>
<style>
    span.dropdown-item{
        cursor: pointer;
    }
</style>
<div class="app-title">
    <div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="/<?= $data['controller_name'] ?>"><?= $language_["authors"] ?></a></li>
        </ul>
    </div>
    <a class="btn btn-primary btn-sm" href="/<?= $data['controller_name'] ?>/add/"><?= $language_["add"] ?></a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title"><?= $language_["allAuthors"] ?></h3>
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
                                                    <th><?= $language_["authorsName"] ?></th>
                                                    <th><?= $language_["academicDegree"] ?></th>
                                                    <th><?= $language_["action"] ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['authors'] as $author) : ?>
                                                    <tr>
                                                        <td><?= $author['name'] ?></td>
                                                        <td><?= $author['degree'] ?></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="/<?= $data['controller_name'] ?>/edit/<?= $author['id'] ?>" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-lg fa-edit"></i> <?= $language_["change"] ?>
                                                                </a>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a href="#" onclick="deleteAuthor(<?= $author['id'] ?>)" class="btn btn-danger btn-sm del-author">
                                                                    <i class="fa fa-lg fa-trash"></i> <?= $language_["delete"] ?>
                                                                </a>
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
<script type="text/javascript" src="/assets/js/plugins/sweetalert.min.js"></script>
<script type="text/javascript">
  //  var test
    $('#sampleTable').DataTable({
        columnDefs: [
            { width: 200, targets: 2 }
        ],
        fixedColumns: true,
        autoWidth: false,        
        language:{           
            url: '<?=$_SESSION['local']?>'=='tj'?'/assets/json/tg.json':'/assets/json/ru.json',
        }
    });

    function deleteAuthor( id ) {
        swal({
            title: "<?= $language_["titileErrorAuthor"] ?>",
            text: "<?= $language_["textErrorAuthor"] ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "<?= $language_["confirmDeleteAuthor"] ?>",
            cancelButtonText: "<?= $language_["rejectDeleteAuthor"] ?>",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "/author/delete",
                    type: "POST",
                    dataType: "json",
                    data:  "id="+id,
                    cache: false,
                    success: function(response)
                    {
                        if(response.error===1){
                            swal("<?= $language_["error"] ?>!", response.message, "error");
                        }else{
                            swal("<?= $language_["success"] ?>!", response.message, "success");
                            location.reload();
                        }
                    },
                    error: function(er)
                    {
                        console.log(er);
                        swal("<?= $language_["error"] ?>!", "<?= $language_["errorMessage"] ?>", "error");
                    }
                });
            } else {
                swal("<?= $language_["canceled"] ?>!", "<?= $language_["declineError"] ?>", "error");
            }
        });
    }
</script>