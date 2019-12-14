<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Список категоий</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= ADMIN ?>">Главная</a></li>
                    <li class="breadcrumb-item">
                        <a href="<?= ADMIN ?>/category">
                            Список категорий
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Новая категория</li>
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
                <form action="<?= ADMIN ?>/category/add" method="post"
                      data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">
                                Наименование категории
                            </label>
                            <input type="text" name="title" class="form-control"
                                id="title"
                                placeholder="Наименование категории" required>
                            <span class="glyphicon form-control-feedback"
                                  aria-hidden="true"></span>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Родительская категория</label>
                            <?php
                            new \app\widgets\menu\Menu([
                                'tpl' => WWW . '/menu/select.php',
                                'container' => 'select',
                                'cache' => 0,
                                'cacheKey' => 'admin_select',
                                'attrs' => [
                                     'name' => 'parent_id',
                                     'id' => 'parent_id',
                                ],
                                'class' => 'form-control',
                                'prepend' => '<option value="0">Самостоятельная категория</option>',
                            ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <label for="keywords">
                                Ключевые слова
                            </label>
                            <input type="text" name="keywords" class="form-control"
                                   id="keywords"
                                   placeholder="Ключевые слова">
                        </div>
                        <div class="form-group">
                            <label for="description">
                                Описание
                            </label>
                            <input type="text" name="description" class="form-control"
                                   id="description"
                                   placeholder="Описание">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">
                            Добавить
                        </button>
                    </div>
                </form>

                    <?php
/*                    new \app\widgets\menu\Menu([
                        'tpl' => WWW . '/menu/category_admin.php',
                        'container' => 'div',
                        'cache' => 0,
                        'cacheKey' => 'admin_cat',
                        'class' => 'list-group list-group-root well',
                    ]);
                    */?>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
