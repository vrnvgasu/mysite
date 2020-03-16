<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Группа фильтров</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= ADMIN ?>">Главная</a></li>
                    <li class="breadcrumb-item active">Группа фильтров</li>
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
                        <a href="<?=ADMIN;?>/filter/group-add"
                            class="btn btn-primary">
                            <i class="fa fa-plus"></i> Добавить группу
                        </a>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Наименование</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tdody>
                                <?php foreach ($attrs_group as $item): ?>
                                <tr>
                                    <td><?= $item->title; ?></td>
                                    <td>
                                        <a href="<?=ADMIN;?>/filter/group-edit?id=<?=$item->id;?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="<?=ADMIN;?>/filter/group-delete?id=<?=$item->id;?>"
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
