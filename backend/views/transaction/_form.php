<?php

use yii\helpers\Html;
use common\widgets\Alert;
use common\models\Account;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">
    <?= Alert::widget([
        'alertTypes' => [
            'createUserTransaction' => 'alert-info'
        ],
    ]) ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'account_from')->dropDownList(Account::getSystemAccountList()) ?>

    <?= $form->field($model, 'account_to')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
