<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Список заказов</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN ?>">Главная</a></li>
                        <li class="breadcrumb-item active">Список заказов</li>
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
                                        <th>Покупатель</th>
                                        <th>Статус</th>
                                        <th>Кол-во товара</th>
                                        <th>Дата создания</th>
                                        <th>Дата изменения</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tdody>
                                    <?php foreach ($orders as $order) : ?>
                                    <?php $class = $order['status'] ? 'success' : ''; ?>
                                    <tr class="<?= $class; ?>">
                                        <td><?= $order['id']; ?></td>
                                        <td><?= $order['name']; ?></td>
                                        <td><?= $order['status'] ? 'Завершен' : 'Новый'; ?></td>
                                        <td><?= $order['sum']; ?> <?= $order['currency']; ?></td>
                                        <td><?= $order['date']; ?></td>
                                        <td><?= $order['update_at']; ?></td>
                                        <td>
                                            <a href="<?=ADMIN;?>/order/view?id=<?=$order['id'];?>">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tdody>
                            </table>
                        </div>
                        <div class="text-center">

                            <p>(<?= count($orders); ?> заказа(ов) из <?= $count; ?>)</p>
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
</div>
<!-- /.content-wrapper -->