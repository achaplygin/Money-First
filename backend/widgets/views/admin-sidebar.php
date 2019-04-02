<?php

use yii\helpers\Html;

/* @var $balances array */

?>

<div>
    <?= Html::a('Import Transactions', ['file/upload'], ['class' => 'btn btn-primary col-lg-12']); ?>
    <br><br>
    <?= Html::a('Create Transaction', ['transaction/create'], ['class' => 'btn btn-success col-lg-12']); ?>
    <br><br>
    <?= Html::a('Edit Users', ['user/index'], ['class' => 'btn btn-danger col-lg-12']); //todo Users Edit   ?>
    <br><br>
    <div>
        <h2>Balances</h2>
        <hr>
        <?php
        foreach ($balances as $name => $value) {
            echo "<h4 class=\"col-lg-4\">"
                . $name
                . "</h4><h4 class=\"col-lg-8\" align='right'>"
                . Yii::$app->formatter->asCurrency($value)
                . "<br></h4>";
        }
        ?>
    </div>
</div>