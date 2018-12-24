<?php

use yii\widgets\ListView;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '{items}{pager}',
    'itemView' => '_item',
    'itemOptions' => [
        'class' => 'col-sm-3'
    ],
    'options' => [
        'tag' => 'div',
        'class' => 'row',
    ],
]);