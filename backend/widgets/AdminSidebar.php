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
            ->joinWith('user', false, 'JOIN')
            ->andWhere('is_admin')
            ->orderBy('account.id')
            ->asArray()->all();
    }


    public function run()
    {
        return $this->render('admin-sidebar', ['balances' => $this->balances]);
    }
}
