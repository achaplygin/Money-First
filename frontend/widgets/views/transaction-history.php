<?php

use yii\grid\GridView;
use common\models\Account;

$list = Account::getSystemAccountList();

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'rowOptions' => function (\common\models\Transaction $model) {

        /** @var \common\models\User $user */
        $user = Yii::$app->user->identity;
        return [
            'style' => $model->isIncome($user) ? 'background: #dfd;' : 'background: #fdd;',
        ];
    },
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' => [
                'style' => 'background: #fff',
            ],
        ],
        [
            'label' => 'Operation Time',
            'attribute' => 'created_at',
        ],
        [
            'attribute' => 'amount',
            'format' => 'currency',
            'label' => 'Amount',
            'contentOptions' => ['style' => 'font-weight: bold;'],
        ],
        [
            'label' => 'to Account',
            'content' => function ($model) use ($list) {
                return $list[$model->account_to];
            }
        ],
        [
            'label' => 'Balance After',
            'content' => function ($model) {
                /** @var \common\models\User $user */
                $user = Yii::$app->user->identity;
                return $model->isIncome($user) ? $model->balance_after_to : $model->balance_after_from;
            },
        ],
    ],
    'layout' => "{items}\n{pager}\n",
]);
