<!--register-starts-->
<div class="register">
    <div class="container">
        <div class="register-top heading">
            <h2>REGISTER</h2>
        </div>
        <div class="register-main">
            <div class="col-md-6 account-left">
                <form method="post" action="user/signup"
                      id="signup" role="form">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input placeholder="Login" type="text" name="login" class="form-control" id="login" required>
                    </div>
                    <div class="form-group">
                        <label for="login">Password</label>
                        <input placeholder="Password" type="text" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="login">Имя</label>
                        <input placeholder="Имя" type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="login">Email</label>
                        <input placeholder="Email" type="text" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="login">Address</label>
                        <input placeholder="Address" type="text" name="address" class="form-control" id="address" required>
                    </div>
                    <div class="address submit">
                        <input type="submit" value="Зарегистрировать">
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--register-end-->