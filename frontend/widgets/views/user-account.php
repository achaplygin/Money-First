<?php
/**
 * @var $balance
 */


?>
<h2 align="left">
    Balance
</h2>
<hr>
<h2 align="right">
    <?php
    if (Yii::$app->user->identity->is_admin) {
        foreach ($balance as $item) {
            echo Yii::$app->formatter->asCurrency($item) . "<br>";
        }
    } else {
        echo Yii::$app->formatter->asCurrency($balance);
    }
    ?>
</h2>
