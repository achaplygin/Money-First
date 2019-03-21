<?php

namespace frontend\models;

use Yii;
use common\models\Account;
use common\models\Transaction;

/**
 * Class UserTransaction
 * @package frontend\models
 */
class UserTransaction extends Transaction
{

    public function createUserTransaction()
    {

        $transaction = Yii::$app->db->beginTransaction();
        try {

            $this->account_from=Yii::$app->user->identity->account->id;
            if ($this->account_to == $this->account_from){
                throw new \Exception('Ты серьёзно? Это ж твой счёт!');
            }

            $systemAccount = Account::findOne($this->account_to);
            $systemAccount->balance += (float)$this->amount;
            $this->balance_after_to = $systemAccount->balance;

            $userAccount = Account::findOne($this->account_from);
            $userAccount->balance -= (float)$this->amount;
            $this->balance_after_from = $userAccount->balance;

            $this->created_at = date('Y-m-d H:i:s', time());
            $this->is_incoming = true;

            if (!$this->save()) {
                throw new \Exception('Error on Transaction->save()');
            }
            if (!$userAccount->save()) {
                throw new \Exception('Error on userAccount->save()');
            }
            if (!$systemAccount->save()) {
                throw new \Exception('Error on systemAccount->save()');
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
