<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Новый пользователь</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= ADMIN ?>">Главная</a></li>
                    <li class="breadcrumb-item"><a href="<?= ADMIN ?>">Список пользователей</a></li>
                    <li class="breadcrumb-item">Новый пользователь</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!--register-starts-->
<div class="register">
    <div class="container">
        <div class="register-top heading">
            <h2>REGISTER</h2>
        </div>
        <div class="register-main">
            <div class="col-md-6 account-left">
                <form method="post" action="<?= ADMIN; ?>/user/add "
                      id="signup" role="form"
                      data-toggle="validator">
                    <!--data-toggle="validator" для валидации на клиенте-->

                    <!--has-feedback - для валидации на клиенте-->
                    <div class="form-group has-feedback">
                        <label for="login">Login</label>
                        <input placeholder="Login" type="text" name="login"
                               class="form-control" id="login" required
                               value="<?=isset($_SESSION['form_data']['login']) ?
                                   h($_SESSION['form_data']['login']) : '';?>">
                        <span class="glyphicon form-control-feedback"
                              aria-hidden="true"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="login">Password</label>
                        <input placeholder="Password" type="password" name="password"
                               class="form-control"
                               id="password" required
                               data-error="Пароль должен включать не менее 6 символов"
                               data-minlength="6">
                        <span class="glyphicon form-control-feedback"
                              aria-hidden="true"></span>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="login">Имя</label>
                        <input placeholder="Имя" type="text" name="name"
                               class="form-control" id="name" required
                               value="<?=isset($_SESSION['form_data']['name']) ?
                                   h($_SESSION['form_data']['name']) : '';?>">
                        <span class="glyphicon form-control-feedback"
                              aria-hidden="true"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="login">Email</label>
                        <input placeholder="Email" type="email" name="email"
                               class="form-control" id="email" required
                               value="<?=isset($_SESSION['form_data']['email']) ?
                                   h($_SESSION['form_data']['email']) : '';?>">
                        <span class="glyphicon form-control-feedback"
                              aria-hidden="true"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="login">Address</label>
                        <input placeholder="Address" type="text" name="address"
                               class="form-control" id="address" required
                               value="<?=isset($_SESSION['form_data']['address']) ?
                                   h($_SESSION['form_data']['address']) : '';?>">
                        <span class="glyphicon form-control-feedback"
                              aria-hidden="true"></span>
                    </div>
                    <div class="form-group">
                        <label for="login">Роль</label>
                        <select class="form-control" name="role">
                            <option value="user">Пользователь</option>
                            <option value="admin">Администратор</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Добавить
                        </button>
                    </div>
                </form>

                <!--Удаляем данные полей формы из сессии
                (срабатывает после заполнения полей)-->
                <?php
                if (isset($_SESSION['form_data'])) {
                    unset($_SESSION['form_data']);
                }
                ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

