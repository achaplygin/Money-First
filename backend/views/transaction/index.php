<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Account;
use common\models\Transaction;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">
    <div class="col-lg-9">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{pager}",
            'rowOptions' => function (Transaction $model) {
                return [
                    'style' => Account::findOne($model->account_to)->user->is_admin ? 'background: #dfd;' : 'background: #fdd;',
                ];
            },
            'columns' => [
                'created_at',
                'user_id:text:Creator Id',
                'user.username:text:Creator',
                'amount:currency',
                'account_from',
                'accountFrom.user.username:text:User From',
                'account_to',
                'accountTo.user.username:text:User To',
            ],
        ]); ?>
    </div>
    <div class="col-lg-3">
        <?= \backend\widgets\AdminSidebar::widget(); ?>
    </div>
</div>
