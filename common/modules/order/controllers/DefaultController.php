<?php

namespace common\modules\order\controllers;

use common\modules\order\models\Order;
use common\modules\cart\helpers\CartHelper;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `order` module
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
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Create new order and change default status
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $cart = CartHelper::getCurrentCart();
        if (!$cart) {
            Yii::$app->session->setFlash('error', "Active default not found");
            return $this->redirect(Yii::$app->homeUrl);
        }
        $model = new Order(['cart_id' => $cart->id]);
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $cart->updateStatus();
                Yii::$app->session->setFlash('success', "Order created successful");
            } else {
                Yii::$app->session->setFlash('error', "Order not created");
            }
            return $this->redirect(Yii::$app->homeUrl);
        }
        return $this->render('create', ['model' => $model]);
    }
}
