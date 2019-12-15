<?php
// перед этим добавили parent_id в реест через CategoryController
$parent_id = \ishop\App::$app->getProperty('parent_id');
?>

<option value="<?= $id; ?>"
    <?php
    if ($id === (int)$parent_id) echo ' selected';
    if (isset($_GET['id']) && (int)$_GET['id'] === $id) echo ' disabled';
    ?>>
    <?= $tab . $category['title']; ?>
</option>
<?php if (isset($category['childs'])): ?>
    <?= $this->getMenuHtml($category['childs'], '&nbsp' . $tab . '-'); ?>
<?php endif; ?>
