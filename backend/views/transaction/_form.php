<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'is_incoming')->checkbox() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'account_to')->textInput() ?>

    <?= $form->field($model, 'account_from')->textInput() ?>

    <?= $form->field($model, 'balance_after_from')->textInput() ?>

    <?= $form->field($model, 'balance_after_to')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
