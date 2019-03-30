<?php

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use backend\models\AccountSearch;
use yii\helpers\Html;
use backend\models\UploadForm;


/* @var $this yii\web\View */

$this->title = 'Admin: MoneyFirst';

//$searchModel = AccountSearch::find()->orderBy('user_id');
//$dataProvider = new ActiveDataProvider([
//    'query' => $searchModel,
//    'pagination' => [
//        'pageSize' => 15,
//    ],
//    'sort' => [
//        'attributes' => [
//            'id',
//            'user_id',
//            'balance',
//            'username',
//            'email',
//        ]
//    ]
//]);

$searchModel = new AccountSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->pagination = ['pageSize' => 15];
$dataProvider->sort = [
    'attributes' => [
        'id',
        'user_id',
        'balance',
        'username',
        'email',
    ]];

?>
<div>
    <div class="col-lg-8">
        <?php echo $this->render('../account/_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-lg-4" align="right">
        <?php echo Html::a('Import Transactions', ['file/upload'], ['class' => 'btn btn-primary']); ?>
        &nbsp;&nbsp;
        <?php echo Html::a('Create Transaction', ['transaction/create'], ['class' => 'btn btn-success']); ?>
    </div>
</div>
<div class="site-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'columns' => [
            'user_id',
            'user.username',
            'user.email',
            'id:integer:Account Id',
            'balance',
        ],
    ]) ?>
</div>
