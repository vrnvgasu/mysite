<h1>Hello, world!</h1>
<p><?= $name; ?></p>
<p><?= $age; ?></p>

<?php foreach ($names as $name) : ?>
    <h3><?= $name ?></h3>
<?php endforeach; ?>

<?php foreach ($posts as $post) : ?>
    <h3><?= $post->title ?></h3>
<?php endforeach; ?>
