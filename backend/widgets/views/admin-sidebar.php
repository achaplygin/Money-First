<?php

use yii\helpers\Html;

/* @var $balances array */

?>

<div>
    <?php echo Html::a('Import Transactions', ['file/upload'], ['class' => 'btn btn-primary col-lg-12']); ?>
    <br><br>
    <?php echo Html::a('Create Transaction', ['transaction/create'], ['class' => 'btn btn-success col-lg-12']); ?>
    <br><br>
    <?php echo Html::a('Edit Users', ['user/index'], ['class' => 'btn btn-danger col-lg-12']); ?>
    <br><br>
    <div>
        <h2>Balances</h2>
        <hr>
        <?php
        foreach ($balances as $value) {
            echo "<h4 class=\"col-lg-4\">"
                . $value['username']
                . "</h4><h4 class=\"col-lg-8\" style='text-align: right'>"
                . Yii::$app->formatter->asCurrency($value['balance'])
                . "<br></h4>";
        }
        ?>
    </div>
</div>
