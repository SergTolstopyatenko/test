<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Product;
use yii\data\ActiveDataProvider;

/**
 * Class ProductList - widget shows list of products which count is greater than zero on main page.
 * @package frontend\widgets
 */
class ProductList extends Widget
{
    /**
     * Page size for list view
     * @var int
     */
    public $pageSize = 4;

    /**
     * @return string
     */
    public function run()
    {

        $query = Product::find()->where(['>', 'amount', 0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);

        return $this->render('product-list/view', [
            'dataProvider' => $dataProvider,
        ]);
    }

}