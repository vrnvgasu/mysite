<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Редактирование пользователя</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= ADMIN ?>">Главная</a></li>
                    <li class="breadcrumb-item"><a href="<?= ADMIN ?>">Список пользователей</a></li>
                    <li class="breadcrumb-item">Редактирование пользователя</li>
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
                <div class="box">
                    <form action="<?= ADMIN ?>/user/edit" method="post"
                          data-toggle="validator">
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="login">
                                    Логин
                                </label>
                                <input type="text" name="login" class="form-control"
                                       id="login"
                                       placeholder="Логин" required
                                       value="<?= h($user->login); ?>">
                                <span class="glyphicon form-control-feedback"
                                      aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">
                                    Пароль
                                </label>
                                <input type="password" name="password" class="form-control"
                                       id="password"
                                       placeholder="Пароль">
                            </div>
                            <div class="form-group has-feedback">
                                <label for="name">
                                    Имя
                                </label>
                                <input type="text" name="name" class="form-control"
                                       id="name"
                                       placeholder="Имя" required
                                       value="<?= h($user->name); ?>">
                                <span class="glyphicon form-control-feedback"
                                      aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="email">
                                    Email
                                </label>
                                <input type="email" name="email" class="form-control"
                                       id="email"
                                       placeholder="Email" required
                                       value="<?= h($user->email); ?>">
                                <span class="glyphicon form-control-feedback"
                                      aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="address">
                                    Адрес
                                </label>
                                <input type="text" name="address" class="form-control"
                                       id="address"
                                       placeholder="Адрес"
                                       value="<?= h($user->address); ?>">
                            </div>
                            <div class="form-group">
                                <label for="role">
                                    Роль
                                </label>
                                <select name="role" id="role" class="form-control">
                                    <option value="user" <?= $user->role === 'user' ? ' selected' : ''; ?>>
                                        Пользователь
                                    </option>
                                    <option value="admin" <?= $user->role === 'admin' ? ' selected' : ''; ?>>
                                        Администратор
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="hidden" name="id"
                                   value="<?= $user->id; ?>">
                            <button type="submit" class="btn btn-primary">
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>

                <h3>Заказы пользователя</h3>
                <?php if ($orders) : ?>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
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
                <?php else: ?>
                    <p class="text-danger">Нет заказов...</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
<!-- /.content -->
