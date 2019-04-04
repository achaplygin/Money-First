<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Upload File Page
 */

$this->title = 'Transactions Import';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="col-lg-4">
    <div>
        <?= $form->field($model, 'xlsFile')->fileInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success col-lg-12']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
