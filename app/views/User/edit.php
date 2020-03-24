<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li class="active"><a href="<?=PATH;?>">Главная</a></li>
                <li class="active">
                    <a href="<?=PATH;?>/user/cabinet">Личный кабент</a>
                </li>
                <li>Изменение личных данных</li>
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
                <form action="/user/edit" method="post"
                  data-toggle="validator">
                <div class="box-body">
                    <div class="form-group has-feedback">
                        <label for="login">
                            Логин
                        </label>
                        <input type="text" name="login" class="form-control"
                               id="login"
                               placeholder="Логин" required
                               value="<?= h($_SESSION['user']['login']); ?>">
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
                               value="<?= h($_SESSION['user']['name']); ?>">
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
                               value="<?= h($_SESSION['user']['email']); ?>">
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
                               value="<?= h($_SESSION['user']['address']); ?>">
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                        Сохранить
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!--login-end-->