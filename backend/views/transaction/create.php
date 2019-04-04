<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */

$this->title = 'Admin: Create Transaction';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <div>
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>
