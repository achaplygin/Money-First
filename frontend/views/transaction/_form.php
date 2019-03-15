<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput() ?>

<!--    <?//= $form->field($model, 'is_incoming')->checkbox() ?>-->

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'account_user')->textInput() ?>

    <?= $form->field($model, 'account_system')->textInput() ?>

    <!--<?/*= $form->field($model, 'created_at')->textInput() */?>-->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
