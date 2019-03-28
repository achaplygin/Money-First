<?php

namespace frontend\models;

use common\models\User;
use Yii;
use common\models\Account;
use common\models\Transaction;

/**
 * Class UserTransaction
 * @package frontend\models
 */
class UserTransaction extends Transaction
{
    public function createUserTransaction(): void
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            /** @var User $usr */
            $usr = Yii::$app->user->identity;
            $this->account_from = $usr->account->id;
            if ((int) $this->account_to === (int) $this->account_from) {
                throw new \Exception('Ты серьёзно? Это ж твой счёт!');
            }

            $systemAccount = Account::findOne($this->account_to);
            $systemAccount->balance += (float)$this->amount;
            $this->balance_after_to = $systemAccount->balance;

            $userAccount = Account::findOne($this->account_from);
            $userAccount->balance -= (float)$this->amount;
            $this->balance_after_from = $userAccount->balance;

            $this->is_incoming = true;

            if (!$this->save()) {
                $ex = new \Exception('Error on Transaction->save()');
                throw $ex;
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
