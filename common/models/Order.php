<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $cart_id
 * @property string $email
 * @property string $phone
 * @property int $status
 *
 * @property Cart $cart
 */
class Order extends \yii\db\ActiveRecord
{

    const ORDER_STATUS_NEW = 0;
    const ORDER_STATUS_COMPLETED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cart_id', 'email', 'phone'], 'required'],
            [['cart_id', 'status'], 'integer'],
            [['email', 'phone'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['cart_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::className(), 'targetAttribute' => ['cart_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cart_id' => 'Cart ID',
            'email' => 'Email',
            'phone' => 'Phone',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }
}
