<?php

namespace common\modules\cart\helpers;

use Yii;
use common\modules\cart\models\Cart;

/**
 * Class CartHelper
 * @package frontend\helpers
 */
class CartHelper
{

    /**
     * Get user default and return count of items in it
     * @return false|int|null|string
     */
    public static function getCartNum()
    {
        $query = self::cartBaseQuery();
        $result = $query->select('num')->scalar();

        return !empty($result) ? $result : 0;
    }

    /**
     * Return current user default
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getCurrentCart()
    {
        $query = self::cartBaseQuery();
        return $query->one();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    private static function cartBaseQuery()
    {
        return Cart::find()->where([
            'user_id' => Yii::$app->user->id,
            'status' => Cart::CART_STATUS_NEW
        ]);
    }
}