<?php

namespace console\controllers;

use common\models\Account;
use common\models\User;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $user=User::find()->orderBy('id')->all();
        echo PHP_EOL;
        echo 'Use "add-money($user_id)" to increase user.balance+=5000';
        echo "\nusr_id\tusername\tbalance";
        foreach ($user as $usr){
            echo "\n".$usr->id."\t".$usr->username."\t\t".$usr->account->balance;
        }
        echo PHP_EOL;
        echo PHP_EOL;

        return 0;
    }


    public function actionAddMoney(int $userId): int
    {
        /** @var Account $acc */
        $acc = Account::findOne(['user_id' => $userId]);

        $acc->balance += 5000;
        $acc->save();

        return 0;
    }
}
