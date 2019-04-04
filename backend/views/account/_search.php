<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-lg-6" style="padding-left: 0px;">
        <?= $form->field($model, 'id') ?>
    </div>

    <div class="col-lg-6" style="padding-left: 0px;">
        <?= $form->field($model, 'user_id') ?>

    </div>

    <div class="col-lg-6" style="padding-left: 0px;">
        <?= $form->field($model, 'username') ?>
    </div>
    <div class="col-lg-6" style="padding-left: 0px;">
        <?= $form->field($model, 'email') ?>
    </div>
    <div class="col-lg-12" style="padding: 0px;">
        <div class="col-lg-3" style="padding-left: 0px;">
            <?= $form->field($model, 'minBalance') ?>
        </div>

        <div class="col-lg-3" style="padding-left: 0px;">
            <?= $form->field($model, 'maxBalance') ?>
        </div>
        <div class="col-lg-6" style="padding-left: 0px; height: 74px;">
            <label>&nbsp;</label>
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary col-lg-12']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
