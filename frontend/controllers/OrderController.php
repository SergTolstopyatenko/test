<?php

namespace frontend\controllers;

use common\models\Order;
use frontend\helpers\CartHelper;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Class OrderController
 * @package frontend\controllers
 */
class OrderController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Create new order and change cart status
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $cart = CartHelper::getCurrentCart();
        if (!$cart) {
            Yii::$app->session->setFlash('error', "Active cart not found");
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