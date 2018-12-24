<?php

namespace common\models\traits;

/**
 * Trait ProductTrait
 * @package common\traits
 */
trait ProductTrait
{

    /**
     * Increment or decrement product amount
     * @param string $type
     */
    public function updateProductAmount($type = 'increment')
    {
        if ($type == 'increment') {
            $this->amount++;
        } else {
            if ($this->amount > 0) {
                $this->amount--;
            }
        }
        $this->save();
    }
}