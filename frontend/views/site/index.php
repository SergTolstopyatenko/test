<?php

/* @var $this yii\web\View */

use frontend\widgets\ProductList;
use common\modules\cart\helpers\CartHelper;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php if(!Yii::$app->user->isGuest): ?>
            <p><?= CartHelper::getCartNum() ?> items in your <a href="<?= Url::to(['/cart/default/view-cart']) ?>">cart</a></p>

            <?= ProductList::widget(); ?>
        <?php else: ?>
            <p>To make a purchase, you need to log in (test/test)</p>
        <?php endif; ?>
    </div>

</div>
