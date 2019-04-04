<?php
/* @var $this yii\web\View */

/* @var $dataProviderFrom yii\data\ActiveDataProvider */
/* @var $dataProviderTo yii\data\ActiveDataProvider */
/* @var $amountFromSum float */
/* @var $amountToSum float */

use common\models\Account;
use common\models\User;
use yii\grid\GridView;

$this->title = 'Statistic';

/* @var User $user */
$user = Yii::$app->user->identity;
$list = Account::getAccountList();

?>

<div>
    <div class="col-lg-6">
        <h3>Outgoing</h3>
        <?=
        GridView::widget([
            'dataProvider' => $dataProviderFrom,
            'layout' => "{items}\n{pager}",
            'columns' => [
                'created_at',
                [
                    'label' => 'Who',
                    'attribute' => 'user_id',
                    'content' => function ($model) {
                        $user = User::findOne($model->user_id);
                        return $user ? $user->username : '';
                    },
                ],
                [
                    'attribute' => 'amount',
                    'format' => 'currency',
                    'contentOptions' => ['style' => 'background: #fdd'],
                ],
                [
                    'label' => 'Account To',
                    'content' => function ($model) use ($list) {
                        return $list[$model->account_to];
                    }
                ],
            ]
            ]
        );
        ?>
        <h3>
            Total Paid
        </h3>
        <hr>
        <h2 style="text-align: right">
            <?php echo Yii::$app->formatter->asCurrency($amountFromSum) ?>
        </h2>
    </div>
    <div class="col-lg-6">
        <h3>Incoming</h3>
        <?=
        GridView::widget(
            [
            'dataProvider' => $dataProviderTo,
            'layout' => "{items}\n{pager}",
            'columns' => [
                'created_at',
                [
                    'label' => 'Who',
                    'attribute' => 'user_id',
                    'content' => function ($model) {
                        $user = User::findOne($model->user_id);
                        return $user ? $user->username : '';
                    },
                ],
                [
                    'attribute' => 'amount',
                    'format' => 'currency',
                    'contentOptions' => ['style' => 'background: #dfd'],
                ],
                [
                    'label' => 'Account From',
                    'content' => function ($model) use ($list) {
                        return $list[$model->account_from];
                    }
                ],
            ]
            ]
        );
        ?>
        <h3>
            Total Received
        </h3>
        <hr>
        <h2 style="text-align: right">
            <?= Yii::$app->formatter->asCurrency($amountToSum) ?>
        </h2>
    </div>
</div>
