<?php
$curr = \ishop\App::$app->getProperty('currency');
?>
<?php if (!empty($products)) : ?>
    <?php foreach ($products as $product) : ?>
        <div class="col-md-4 product-left p-left">
            <div class="product-main simpleCart_shelfItem">
                <a href="product/<?=$product->alias;?>"
                   class="mask">
                    <img class="img-responsive zoom-img"
                         src="images/<?=$product->img;?>" alt="" />
                </a>
                <div class="product-bottom">
                    <h3><?=$product->title;?></h3>
                    <p><?=$product->content;?></p>
                    <h4>
                        <!--href="cart/add?id=$product->id" на тот случай, если отключен js-->
                        <a data-id="<?=$product->id;?>" class="add-to-cart-link" href="cart/add?id=<?=$product->id?>"><i></i></a> <span class=" item_price">
                                            <?= $curr['symbol_left']; ?> <?=round($product->price * $curr['value']);?> <?= $curr['symbol_right']; ?>
                                        </span>
                        <?php if ($product->old_price) : ?>
                            <small><del>
                                    <?= $curr['symbol_left']; ?> <?=round($product->old_price * $curr['value']);?> <?= $curr['symbol_right']; ?>
                                </del></small>
                        <?php endif; ?>
                    </h4>
                </div>
                <div class="srch srch1">
                    <span>-50%</span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <p>(<?=count($products);?> товара(ов) из <?=$total;?>)</p>
    <?php if ($pagination->countPages > 1): ?>
        <?=$pagination;?>
    <?php endif; ?>
<?php else : ?>
    <h3>В данной категории товаров пока нет.</h3>
<?php endif; ?>