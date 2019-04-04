<?php
/** @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;
use common\models\User;
use common\models\Account;

/** @var \common\models\User $user */
$user = Yii::$app->user->identity;
$list = Account::getAccountList();

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'rowOptions' => function (\common\models\Transaction $model) use ($user) {

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
            'label' => 'Who',
            'attribute' => 'user_id',
            'content' => function ($model) {
                if (!User::findOne($model->user_id) == null) {
                    return User::findOne($model->user_id)->username;
                } else {
                    return '?!';
                }
            },
        ],
        [
            'attribute' => 'amount',
            'format' => 'currency',
            'label' => 'Amount',
            'contentOptions' => ['style' => 'font-weight: bold;'],
        ],
        [
            'label' => 'Account',
            'content' => function ($model) use ($list, $user) {
                /** @var \common\models\Transaction $model */
                return $model->isIncome($user) ? $list[$model->account_from] : $list[$model->account_to];
            }
        ],
        [
            'label' => 'Balance After',
            'content' => function ($model) {
                /** @var \common\models\User $user */
                $user = Yii::$app->user->identity;
                /** @var \common\models\Transaction $model */
                return $model->isIncome($user) ? $model->balance_after_to : $model->balance_after_from;
            },
        ],
    ],
    'layout' => "{items}\n{pager}\n",
]);
