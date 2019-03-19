<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Transaction create';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= $message ?>
        <br>
        If you have money, please fill out the following form to donate. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'transaction-create-form']); ?>

                <?= $form->field($model, 'amount')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'account_id') ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
