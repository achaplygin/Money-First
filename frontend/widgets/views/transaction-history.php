<?php

use yii\grid\GridView;
use common\models\Account;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'rowOptions' => function ($model) {
        if ($model->account_to == Yii::$app->user->identity->account->id) {
            $style = 'background: #dfd;';
        } else {
            $style = 'background: #fdd;';
        }
        return [
            'style' => $style,
        ];
    },
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' => [
                'style' => 'background: #fff'],
        ],
        [
            'label' => 'Operation Time',
            'attribute' => 'created_at',
        ],
        [
            'label' => 'Amount',
            'content' => function ($model) {
                return '$ ' . $model->amount;
            },
            'contentOptions' => ['style' => 'font-weight: bold;']
        ],
        [
            'label' => 'to Account',
            'content' => function ($model) {
                $list = Account::getSystemAccountList();
                $idx = $model->account_to;
                $label = $list[$idx];
                return $label;
            }
        ],
        [
            'label' => 'Balance After',
            'content' => function ($model) {
                if ($model->account_to == Yii::$app->user->identity->account->id) {
                    return '$ ' . $model->balance_after_to;
                } else {
                    return '$ ' . $model->balance_after_from;
                }
            },
        ],
    ],
    'layout' => "{items}\n{pager}\n",
]);
