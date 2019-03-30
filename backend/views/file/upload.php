<?php

use yii\helpers\Html;
use common\models\User;
use yii\widgets\ActiveForm;
use common\models\Transaction;
use backend\models\TransactionImport;

echo '<div><div class="col-lg-6">';
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'xlsFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

<?php // todo Удалть отладочный блок (не забыть закрыть <div>)


if (!$model->fullPath == '') {

    $res = TransactionImport::readFile($model->fullPath);
echo '<div class="col-lg-6">';
    foreach ($res as $i => $item)
        if (Transaction::find()
            ->andWhere([
                'amount' => $item['amount'],
                'user_id' => $item['user_id'],
                'created_at' => $item['created_at'],
            ])->exists()) {
            echo $i . " exists<br>";
        } else {
            echo $i . " not exists<br>";
        }
    echo '</div><div class="col-lg-6">';

    foreach ($res as $i => $item) {
        $model = new TransactionImport();
        $model->attributes = $item;
        if (!$model->validate()) {
            echo '_fail:' . $i . '<br>';
        } else {
            echo '_success:' . $i . '<br>';
        }
    }
    echo '</div>';
    foreach ($res as $i => $item)
        var_dump(Transaction::find()
            ->andWhere([
                'amount' => $item['amount'],
                'user_id' => $item['user_id'],
                'created_at' => $item['created_at'],
            ])->asArray()->all());

    echo '</div><div class="col-lg-6">';

    var_dump($res);

} else {
    echo $model->fullPath . 'отладочный блок';
}

echo '</div></div>';
