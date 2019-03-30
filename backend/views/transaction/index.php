<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Account;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function (\common\models\Transaction $model) {
            return [
                'style' => Account::findOne($model->account_to)->user->is_admin ? 'background: #dfd;' : 'background: #fdd;',
            ];
        },
        'columns' => [
            'created_at',
            'user_id:text:Creator',
            'amount',
            [
                'label' => 'User From',
                'content' => function ($model) {
                    return Account::findOne($model->account_from)->username . ' account:' . $model->account_from;
                }
            ],
            [
                'label' => 'User To',
                'content' => function ($model) {
                    return $model->account_to . Account::findOne($model->account_to)->username . ' - Account: ' . $model->account_to;
                }
            ],
        ],
        'layout' => "{items}\n{pager}",
    ]); ?>
</div>
