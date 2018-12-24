<?php

namespace common\modules\cart\components;

use Yii;
use yii\base\BaseObject;
use common\models\Product;
use common\modules\cart\models\Cart;
use common\modules\cart\models\CartItem;

/**
 * Class CartComponent
 * @package common\components
 */
class CartComponent extends BaseObject
{
    private $_cart;
    private $_cartItem;
    private $_product;

    /**
     * CartComponent constructor.
     * @param Cart $cart
     * @param CartItem $cartItem
     */
    public function __construct(Cart $cart, CartItem $cartItem)
    {
        $this->_cart = $cart;
        $this->_cart->user_id = Yii::$app->user->id;
        $this->_cart->num = 0;
        $this->_cart->total = 0;
        $this->_cartItem = $cartItem;
    }

    /**
     * @param $id
     * @return bool
     */
    public function addToCart($id)
    {
        $this->_product = Product::findOne($id);
        if (!isset($this->_product) || $this->_product->amount < 1) {
            Yii::$app->session->setFlash('error', "Product not found or ended");
            return false;
        }
        $this->setCartData();
        $this->incrementCartItem();
        Yii::$app->session->setFlash('success', "Product add to your cart");
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function removeFromCart($id)
    {
        $item = CartItem::find()
            ->where(['id' => $id])
            ->with('cart')
            ->one();

        if (isset($item) && $item['cart']->user_id == Yii::$app->user->id && $item['cart']->status == Cart::CART_STATUS_NEW) {
            $this->_cart = $item['cart'];
            $this->_cartItem = $item;
            $this->_product = Product::findOne($this->_cartItem->product_id);
            $this->decrementCartItem();
            Yii::$app->session->setFlash('success', "Product was removed from your cart");
        } else {
            Yii::$app->session->setFlash('error', "An error occurred while deleting");
        }
    }

    /**
     * Check cart and cart item and set data to properties if it exists
     */
    private function setCartData()
    {
        $existsCart = Cart::findOne([
            'user_id' => Yii::$app->user->id,
            'status' => Cart::CART_STATUS_NEW
        ]);
        if (!isset($existsCart)) {
            $this->_cart->save();
        } else {
            $this->_cart = $existsCart;
        }
        $existsCartItem = CartItem::findOne([
            'cart_id' => $this->_cart->id,
            'product_id' => $this->_product->id,
        ]);
        if (isset($existsCartItem)) {
            $this->_cartItem = $existsCartItem;
        }
    }

    /**
     * Increments cart item and cart data
     */
    private function incrementCartItem()
    {
        if (!$this->_cartItem->id) {
            $this->_cartItem->cart_id = $this->_cart->id;
            $this->_cartItem->product_id = $this->_product->id;
        }
        $this->_cartItem->amount = ($this->_cartItem->id) ? $this->_cartItem->amount + 1 : 1;
        $this->_cartItem->price = $this->_product->price;
        $this->_cartItem->save();

        $this->_cart->num++;
        $this->_cart->total = $this->_cart->total + $this->_product->price;
        $this->_cart->save();

        $this->_product->updateProductAmount('decrement');

    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function decrementCartItem()
    {
        $this->_cart->num--;
        $this->_cart->total = $this->_cart->total - $this->_cartItem->price;
        $this->_cart->save();

        if ($this->_cart->num == 0) {
            $this->_cart->delete();
        }

        $this->_cartItem->amount--;
        $this->_cartItem->save();
        if ($this->_cartItem->amount == 0) {
            $this->_cartItem->delete();
        }

        $this->_product->updateProductAmount('increment');
    }

}