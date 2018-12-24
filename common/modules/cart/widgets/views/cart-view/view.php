<?php
    use yii\helpers\Url;
?>
<?php if (!$cart): ?>
    <div class="jumbotron">
        <p>Your cart is empty</p>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($cart['cartItems'] as $key => $item): ?>
            <?= $this->render('_item', [
                'index' => $key,
                'item' => $item,
            ]); ?>
        <?php endforeach; ?>
        <h3>Total price: <?= $cart->total ?></h3>
        <a href="<?= Url::to(['/order/default/create']) ?>" class="btn-success btn-lg">Create order</a>
    </div>
<?php endif; ?>

