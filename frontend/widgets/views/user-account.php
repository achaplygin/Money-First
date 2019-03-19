<?php

use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $balance
 */
echo Html::h1('My Accounts', ['class' => 'btn btn-primary col-lg-12']);
echo $balance;
//echo GridView::widget([
//    'dataProvider' => $dataProvider,
//    //'filterModel' => $searchModel,
//    'layout'=> "{items}\n{pager}",
//    'columns' => [
//        'id',
//        'balance',
//    ],
//]);
