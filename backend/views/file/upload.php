<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div>
    <div class="col-lg-9">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'xlsFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

    </div>
    <div class="col-lg-3">
        <?= \backend\widgets\AdminSidebar::widget() ?>
    </div>
</div>

