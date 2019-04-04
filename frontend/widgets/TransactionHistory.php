<?php

namespace frontend\widgets;

use Yii;
use common\models\Account;
use common\models\Transaction;
use yii\data\ActiveDataProvider;

/**
 * Class UserAccount
 *
 * @package common\widgets
 */
class TransactionHistory extends \yii\bootstrap\Widget
{

    public $dataProvider;

    /**
     * Inits $searchModel & dataProvider;
     */
    public function init()
    {
        $history = Transaction::find()
            ->select('created_at, user_id, amount, account_from, account_to, balance_after_to, balance_after_from')
            ->where(['account_from' => Account::findOne(['user_id' => Yii::$app->user->getId()])])
            ->orWhere(['account_to' => Account::findOne(['user_id' => Yii::$app->user->getId()])])
            ->orderBy('created_at DESC');
        $this->dataProvider = new ActiveDataProvider(
            [
            'query' => $history,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => false,
            ]
        );
    }

    /**
     * render view file
     *
     * @return string
     */
    public function run()
    {
        return $this->render('transaction-history', ['dataProvider' => $this->dataProvider]);
    }

}
