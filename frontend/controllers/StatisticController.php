<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use common\models\Transaction;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Statistic controller
 */
class StatisticController extends Controller
{

    public function actionIndex()
    {
        /* @var User $userAccId */
        $userAccId = Yii::$app->user->identity->account->id;
        $transactionsFrom = Transaction::find()
            ->andWhere(['account_from' => $userAccId]);
        $amountFromSum = $transactionsFrom->sum('amount');

        $dataProviderFrom = new ActiveDataProvider([
            'query' => $transactionsFrom,
            'pagination' => [
                'pageParam' => 'from-page',
                'pageSize' => 10
            ],
            'sort' => false,
        ]);

        $transactionsTo = Transaction::find()
            ->andWhere(['account_to' => $userAccId]);
        $amountToSum = $transactionsTo->sum('amount');

        $dataProviderTo = new ActiveDataProvider([
            'query' => $transactionsTo,
            'pagination' => [
                'pageParam' => 'to-page',
                'pageSize' => 10
            ],
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProviderFrom' => $dataProviderFrom,
            'dataProviderTo' => $dataProviderTo,
            'amountFromSum' => $amountFromSum,
            'amountToSum' => $amountToSum,
        ]);
    }

}
