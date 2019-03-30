<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <div class="col-lg-6">
        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)); ?>
        </div>
        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>
    </div>
    <div class="col-lg-6">
        <?php
        if (Yii::$app->response->statusCode === 403) {
            echo Html::img('/error/403.png', ['style' => 'display: block; margin-left: auto; margin-right: auto;']);
        }
        if (Yii::$app->response->statusCode === 404) {
            echo Html::img('/error/404.gif', ['style' => 'display: block; margin-left: auto; margin-right: auto;']);
        }
        ?>
    </div>
    &nbsp;
    <hr>
</div>
