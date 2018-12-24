<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\Cart;

/**
 * Class CartView - widget shows list of cart items in current cart
 * @package frontend\widgets
 */
class CartView extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $cart = Cart::find()
            ->where([
            'user_id' => Yii::$app->user->id,
            'status' => Cart::CART_STATUS_NEW
            ])
            ->with('cartItems')
            ->one();

        return $this->render('cart-view/view', [
            'cart' => $cart,
        ]);
    }

}