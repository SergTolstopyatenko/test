<?php

use yii\helpers\Url;

?>
<div>
    <h3><?= $model->name; ?></h3>
    <p>Price: <?= $model->price; ?></p>
    <a href="<?= Url::to(['/cart/default/add-to-cart', 'id' => $model->id]) ?>" class="btn btn-success">Buy</a>
</div>