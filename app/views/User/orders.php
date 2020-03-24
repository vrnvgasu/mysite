<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li class="active"><a href="<?=PATH;?>">Главная</a></li>
                <li class="active">
                    <a href="<?=PATH;?>/user/cabinet">Личный кабент</a>
                </li>
                <li>История заказов</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->

<!--login-starts-->
<div class="register">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12 prdt-left">
                <?php if ($orders): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                            <tr>
                                <th style="width: 10%">ID</th>
                                <th style="width: 10%">Статус</th>
                                <th style="width: 10%">Сумма</th>
                                <th style="width: 10%">Дата создания</th>
                                <th style="width: 10%">Дата изменения</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <?php
                                if ($order['status'] == 1) {
                                    $class = 'success';
                                    $text = 'Завершен';
                                } elseif ($order['status'] == 2) {
                                    $class = 'info';
                                    $text = 'Оплачен';
                                } else {
                                    $class = '';
                                    $text = 'Новый';
                                }

                                $class = $order['status'] ? 'success' : '';
                                ?>
                                <tr class="<?= $class; ?>">
                                    <td><?= $order['id']; ?></td>
                                    <td><?= $text; ?></td>
                                    <td><?= $order['sum']; ?> <?= $order['currency']; ?></td>
                                    <td><?= $order['date']; ?></td>
                                    <td><?= $order['update_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-danger">
                        Вы пока не совершали заказов...
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!--login-end-->