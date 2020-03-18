<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Список валют</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= ADMIN ?>">Главная</a></li>
                    <li class="breadcrumb-item active">Список валют</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Наименование</th>
                                <th>Код</th>
                                <th>Значение</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tdody>
                                <?php foreach ($currencies as $currency) : ?>
                                    <tr>
                                        <td><?= $currency->id; ?></td>
                                        <td><?= $currency->title; ?></td>
                                        <td><?= $currency->code; ?></td>
                                        <td><?= $currency->value; ?></td>

                                        <td>
                                            <a href="<?=ADMIN;?>/currency/edit?id=<?=$currency->id;?>">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="<?=ADMIN;?>/currency/delete?id=<?=$currency->id;?>"
                                               class="delete text-danger">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tdody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
