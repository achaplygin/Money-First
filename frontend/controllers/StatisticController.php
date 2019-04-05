<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Transaction;
use yii\data\ActiveDataProvider;

/**
 * Statistic controller
 */
class StatisticController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Index page of user's statistic.
     * Collecting incoming and outgoing transactions for current user.
     * Calculating total sum for each of directions.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userAccId = Yii::$app->user->identity->account->id;
        $transactionsFrom = Transaction::find()
            ->andWhere(['account_from' => $userAccId]);
        $amountFromSum = $transactionsFrom->sum('amount');

        $dataProviderFrom = new ActiveDataProvider(
            [
                'query' => $transactionsFrom,
                'pagination' => [
                    'pageParam' => 'from-page',
                    'pageSize' => 10
                ],
                'sort' => false,
            ]
        );

        $transactionsTo = Transaction::find()
            ->andWhere(['account_to' => $userAccId]);
        $amountToSum = $transactionsTo->sum('amount');

        $dataProviderTo = new ActiveDataProvider(
            [
                'query' => $transactionsTo,
                'pagination' => [
                    'pageParam' => 'to-page',
                    'pageSize' => 10
                ],
                'sort' => false,
            ]
        );

        return $this->render(
            'index', [
                'dataProviderFrom' => $dataProviderFrom,
                'dataProviderTo' => $dataProviderTo,
                'amountFromSum' => $amountFromSum,
                'amountToSum' => $amountToSum,
            ]
        );
    }

}
