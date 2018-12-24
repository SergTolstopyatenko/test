<?php

namespace common\modules\cart\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `cart` module
 */
class DefaultController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['add-to-cart', 'remove-item', 'view-cart'],
                'rules' => [
                    [
                        'actions' => ['add-to-cart', 'remove-item', 'view-cart'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Add product to cart
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionAddToCart($id)
    {
        $cart = Yii::$container->get('common\modules\cart\components\CartComponent');
        $cart->addToCart($id);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }


    /**
     * Remove item from cart
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionRemoveItem($id)
    {
        $cart = Yii::$container->get('common\modules\cart\components\CartComponent');
        $cart->removeFromCart($id);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * @return string
     */
    public function actionViewCart()
    {
        return $this->render('view-cart');
    }
}
