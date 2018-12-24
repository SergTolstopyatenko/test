<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'cart' => [
            'class' => 'common\modules\cart\CartModule',
        ],
        'order' => [
            'class' => 'common\modules\order\OrderModule',
        ],
    ],
];
