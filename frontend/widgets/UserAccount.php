<?php

namespace frontend\widgets;

use Yii;
use common\models\User;
use common\models\Account;

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
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if (!$user->is_admin) {
            $this->balance = Account::findOne(['user_id' => $user->getId()])->balance;
        } else {
            $this->balance = Account::find()
                ->select('balance')
                ->andWhere(['user_id' => $user->getId()])
                ->orderBy('id')
                ->asArray()
                ->column();
        }
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
