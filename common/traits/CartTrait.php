<?php

namespace common\traits;

use common\models\Cart;

/**
 * Trait CartTrait
 * @package common\traits
 */
trait CartTrait
{
    /**
     * Update cart status to ordered
     */
    public function updateStatus()
    {
        $this->status = Cart::CART_STATUS_ORDERED;
        $this->save();
    }
}