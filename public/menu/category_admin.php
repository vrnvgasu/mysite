<?php
$parent = (isset($category['childs']));

// можем удалить категорию, только если нет потомков
if (!$parent) {
    $delete = '<a href="' . ADMIN . '/category/delete?id=' . $id . '" 
        class="delete"><i class="fa fa-trash text-danger"></i></a>';
} else {
    $delete = '<i class="fa fa-trash bg-gray-active color-palette"></i>';
}
?>

<p class="item-p">
    <a href="<?=ADMIN;?>/category/edit?id=<?=$id;?>"
       class="list-group-item">
        <?=$category['title'];?>
    </a>
    <span><?= $delete; ?></span>
</p>

<?php if ($parent): ?>
    <div class="list-group">
        <?= $this->getMenuHtml($category['childs']); ?>
    </div>
<?php endif; ?>
