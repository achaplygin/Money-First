<?php
/**
 * @var $balance
 */
use yii\helpers\Html;

?>
<h2 align="left">
    Balance
</h2>
<hr>
<h2 align="right">
    <?= Yii::$app->formatter->asCurrency($balance); ?>
</h2>
