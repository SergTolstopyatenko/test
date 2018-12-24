<?php

namespace common\modules\cart\models\traits;

use common\modules\cart\models\Cart;

/**
 * Trait CartTrait
 * @package common\traits
 */
trait CartTrait
{
    /**
     * Update default status to ordered
     */
    public function updateStatus()
    {
        $this->status = Cart::CART_STATUS_ORDERED;
        $this->save();
    }
}