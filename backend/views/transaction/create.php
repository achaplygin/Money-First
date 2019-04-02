<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */

$this->title = 'Create Transaction';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-create">
<div class="col-lg-9">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
    <div class="col-lg-3">
        <?= \backend\widgets\AdminSidebar::widget() ?>
    </div>
</div>
