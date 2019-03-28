<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'thousandSeparator' => '&nbsp;',
            'currencyCode' => '$',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];

