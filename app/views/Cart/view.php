<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li class="active"><a href="<?=PATH;?>">Главная</a></li>
                <li>Корзина</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->

<!--оформление заказа-start-->
<div class="prdt">
    <div class="prdt-top">
        <div class="col-md-12">
            <div class="product-one cart">
                <div class="register-top heading">
                    <h2>Оформление заказа</h2>
                </div>
                <br><br>

                <?php if (!empty($_SESSION['cart'])) : ?>
                    <div class="table-responsive cart">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Фото</th>
                                <th>Наименование</th>
                                <th>Кол-во</th>
                                <th>Цена</th>
                                <th>
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item) : ?>
                                <tr>
                                    <td>
                                        <a href="product/<?=$item['alias'];?>">
                                            <img src="images/<?=$item['img'];?>" alt="<?=$item['title'];?>">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="product/<?=$item['alias'];?>">
                                            <?=$item['title'];?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="product/<?=$item['alias'];?>">
                                            <?=$item['qty'];?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="product/<?=$item['alias'];?>">
                                            <?=$item['price'];?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/cart/delete/?id=<?=$id;?>">
                                            <span class="glyphicon glyphicon-remove text-danger del-item"
                                              aria-hidden="true"
                                              data-id="<?=$id;?>"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td>Итого:</td>
                                <td colspan="4" class="text-right cart-qty">
                                    <?=$_SESSION['cart.qty'];?>
                                </td>
                            </tr>
                            <tr>
                                <td>На сумму:</td>
                                <td colspan="4" class="text-right cart-sum">
                                    <?=$_SESSION['cart.currency'] ['symbol_left'] . ' ' .
                                    $_SESSION['cart.sum'] . ' ' .
                                    $_SESSION['cart.currency'] ['symbol_right'];?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6 account-left">
                        <form method="post" action="cart/checkout "
                              id="signup" role="form"
                              data-toggle="validator">

                            <!--если не зарегистрирован, то сразу регистрируем-->
                            <?php if (!isset($_SESSION['user'])) : ?>
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

                            <?php endif; ?>

                            <div class="form-group">
                                <label for="note">Примечания</label>
                                <textarea name="note" class="form-control" id="note"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="pay">
                                <input type="checkbox" id="pay" name="pay">
                                    Оплатить онлайн
                                </label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Оформить
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

                <?php else : ?>
                    <h3>Корзина пуста</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<!--оформление заказа-end-->