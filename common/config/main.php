<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy H:i:s',
            'thousandSeparator' => '&nbsp;',
            'currencyCode' => 'USD',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
