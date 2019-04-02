<?php


namespace backend\widgets;


use common\models\Account;

class AdminSidebar extends \yii\bootstrap\Widget
{

    public $balances;

    public function init()
    {
        $this->balances = Account::find()
            ->select('balance, username')
            ->joinWith('user', false)
            ->andWhere('is_admin')
            ->orderBy('user.id')
            ->indexBy('username')
            ->column();
    }


    public function run()
    {
        return $this->render('admin-sidebar', ['balances' => $this->balances]);
    }
}
