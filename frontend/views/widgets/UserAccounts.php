<?php

use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $dataProvider
 * @var $searchModel
 */
echo Html::a('My Accounts', ['/account'], ['class' => 'btn btn-default col-lg-12']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout'=> "{items}\n{pager}",
    'columns' => [
        'id',
        'balance',
    ],
]);
