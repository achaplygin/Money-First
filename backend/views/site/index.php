<?php

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\Account;
use frontend\widgets\UserAccount;
use common\models\User;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

$contractors = Account::find()->joinWith('user', true)/*->andWhere('NOT "user".is_admin')*/;
$dataProvider = new ActiveDataProvider([
    'query' => $contractors,
    'pagination' => [
        'pageSize' => 15,
    ],
    'sort' => [
        'attributes' => [
            'id',
            'user_id',
            'user.username',
            'balance',
            'user.email',
        ]
    ]
]);


?>
<div class="site-index">
    Привет :)
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $contractors,
        'layout' => "{items}\n{pager}",
        'columns' => [
            'user_id',
            'user.username:raw:Username',
            'user.email:raw:Email',
            [
                'attribute' => 'user.is_admin',
                'filter' => array("0"=>'false',"1"=>'true'),
                'content' => function ($model){
                    return $model->user->is_admin ? 'true' : 'false';
                },
            ],
            'id:raw:Account Id',
            'balance',
        ],
    ]) ?>
</div>
