<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
        $a= new yii\grid\ActionColumn();
        $a->buttonOptions=[['view', 'update'], 'isVisible' => false]
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=> "{items}\n{pager}",
        'columns' => [
            'id',
            'balance',
            ['class' => 'yii\grid\ActionColumn',
            'visibleButtons' => ['update'=>false, 'view'=>true, 'delete'=>false],
            ]
        ],
    ]); ?>


</div>
