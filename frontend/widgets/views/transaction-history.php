<?php

use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'rowOptions' => function ($model) {
        if ($model->is_incoming) {
            $style = 'background: #fdd;';
        } else {
            $style = 'background: #dfd;';
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
        'created_at',
        'amount',
        'account_id',
        [
            'label' => 'Balance After',
            'content' => function ($model) {
                return '$ '.$balance_after=($model->is_incoming) ? $model->balance_after_from : $model->balance_after_to;
            },
        ],
    ],
    'layout' => "{items}\n{pager}\n",
]);
