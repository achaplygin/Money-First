<?php

use yii\helpers\Html;
use common\widgets\Alert;
use common\models\Account;
use yii\bootstrap\ActiveForm;
use frontend\widgets\UserAccount;


$this->title = 'Transaction create';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-lg-9">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="col-lg-6">

                <?= Alert::widget([
                    'alertTypes' => [
                        'createUserTransaction' => 'alert-info'
                    ],
                    ]
                ) ?>
                <?php $form = ActiveForm::begin(['id' => 'transaction-create-form']); ?>

                <?= $form->field($model, 'amount')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'account_to')->dropDownList(Account::getAccountList(true)) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to send your money?',
                            'method' => 'post',
                        ],]
                    ) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="col-lg-3">
            <?= UserAccount::widget() ?>
        </div>
    </div>
<?php
