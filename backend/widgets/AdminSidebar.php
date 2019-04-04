<?php

namespace backend\widgets;

use common\models\Account;

/**
 * Class AdminSidebar
 * Widget with system accounts's balances and admin's actions buttons.
 *
 * @property float $balances
 * @package  backend\widgets
 */
class AdminSidebar extends \yii\bootstrap\Widget
{

    public $balances;

    /**
     * Get array of admin's balances
     */
    public function init()
    {
        $this->balances = Account::find()
            ->select('balance, username')
            ->joinWith('user', false, 'JOIN')
            ->andWhere('is_admin')
            ->orderBy('account.id')
            ->asArray()->all();
    }


    /**
     * Run widget with array of balances
     *
     * @return string
     */
    public function run()
    {
        return $this->render('admin-sidebar', ['balances' => $this->balances]);
    }
}
