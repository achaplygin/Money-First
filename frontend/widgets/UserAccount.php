<?php

namespace frontend\widgets;

use common\models\Account;
use Yii;

/**
 * Class UserAccount
 * @package common\widgets
 */
class UserAccount extends \yii\bootstrap\Widget
{

    public $balance;

    /**
     * Inits $searchModel & dataProvider;
     */
    public function init()
    {
        $this->balance = Account::findOne(['user_id' => Yii::$app->user->getId()])->balance;
    }

    /**
     * render view file
     * @return string
     */
    public function run()
    {
        return $this->render('user-account', ['balance' => $this->balance]);
    }

}
