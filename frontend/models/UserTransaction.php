<?php

namespace frontend\models;

use common\models\Account;
use Yii;
use common\models\Transaction;

/**
 * Class UserTransaction
 * @package frontend\models
 */
class UserTransaction extends Transaction
{
    /**
     * @return bool
     */
    public function createUserTransaction()
    {

        $transaction = Yii::$app->db->beginTransaction();
        try {

            $systemAccount = Account::findOne($this->account_id);
            $userAccount = Account::findOne($this->user_id);
            $systemAccount->balance += (float)$this->amount;
            $userAccount->balance -= (float)$this->amount;

            $this->balance_after_from = $userAccount->balance;
            $this->balance_after_to = $systemAccount->balance;
            $this->created_at = date('Y-m-d H:i:s', time());
            $this->is_incoming=true;

            $userAccount->save();
            $systemAccount->save();
            $this->save();

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
