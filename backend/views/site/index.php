<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $balances array */
/* @var $searchModel \backend\models\AccountSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Admin: MoneyFirst';
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
    <div class="col-lg-12">
        <?php echo $this->render('../account/_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-lg-12" style="padding-left: 0"><br>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{pager}",
            'columns' => [
                'user_id',
                'user.username:text:Username',
                'user.email:email:Email',
                'id:integer:Account Id',
                [
                    'attribute' => 'balance',
                    'format' => 'currency',
                    'contentOptions' => function ($model) {
                        return [
                            'style' => $model->balance >= 0 ? '' : 'color: red',
                        ];
                    },
                ],
            ],
            'rowOptions' => function ($model) {
                return [
                    'style' => $model->user->is_admin ? 'font-weight: bold;' : '',
                ];
            },
            ]
        ) ?>
    </div>
</div>
