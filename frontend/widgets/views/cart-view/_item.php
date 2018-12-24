<?php
use yii\helpers\Url;
?>
<div class="col-md-12">
    <p>Item #<?= $index + 1 ?></p>
    <p><?= $item->product->name ?>, amount: <?= $item->amount ?>, price: <?= $item->price ?>, total: <?= $item->amount * $item->price ?></p>
    <p><a href="<?= Url::to(['/cart/remove-item', 'id' => $item->id]) ?>" class="btn-sm btn-danger">Delete</a></p>
    <hr>
</div>