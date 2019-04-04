<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $model backend\models\UserForm */

$this->title = 'Update User: ' . $user->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-8">
        <?= DetailView::widget([
            'model' => $user,
            'attributes' => [
                'id',
                'username',
                'email:email',
                'is_admin:boolean',
                'status',
                'created_at:datetime',
                'updated_at:datetime',
                'password_reset_token',
                'auth_token',
            ],
            ]
        ) ?>
    </div>

    <div class="col-lg-4">
        <?= $this->render('_form', [
            'model' => $model,
            ]
        )
?>
    </div>

</div>
