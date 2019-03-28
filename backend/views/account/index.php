<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-9">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'user_id',
                    'balance',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
                'layout' => "{items}\n{pager}"
            ]); ?>
        </div>
        <div class="col-lg-3">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>
    <p>
        <?= Html::a('Create Account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
