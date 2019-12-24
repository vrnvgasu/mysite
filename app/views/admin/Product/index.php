<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Список товаров</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= ADMIN ?>">Главная</a></li>
                    <li class="breadcrumb-item active">Список товаров</li>
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
                                <th>Категория</th>
                                <th>Наименование</th>
                                <th>Цена</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tdody>
                                <?php foreach ($products as $product) : ?>
                                    <tr>
                                        <td><?= $product['id']; ?></td>
                                        <td><?= $product['cat']; ?></td>
                                        <td><?= $product['title']; ?></td>
                                        <td><?= $product['price']; ?></td>
                                        <td><?= $product['status'] ? 'On' : 'Off'; ?></td>
                                        <td>
                                            <a href="<?=ADMIN;?>/product/edit?id=<?=$product['id'];?>">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="<?=ADMIN;?>/product/delete?id=<?=$product['id'];?>"
                                               class="delete">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tdody>
                        </table>
                    </div>
                    <div class="text-center">
                        <p>(<?= count($products); ?> товар(ов) из <?= $count; ?>)</p>
                        <?php if ($pagination->countPages > 1): ?>
                            <?=$pagination;?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
