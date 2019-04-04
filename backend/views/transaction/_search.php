<?php
/**
 * Used on index page of "Transactions"
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-lg-3">
        <?= $form->field($model, 'minAmount') ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'maxAmount') ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'user_id') ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'creator') ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'userFrom') ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'userTo') ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'minDate')->input('date') ?>
    </div>
    <div class="col-lg-3">
        <?= $form->field($model, 'maxDate')->input('date') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', '/transaction', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
