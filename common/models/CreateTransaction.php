<?php

namespace common\models;

use Yii;

/**
 * Class UserTransaction
 * @package frontend\models
 */
class CreateTransaction extends Transaction
{

    /**
     * Creating transaction and modify account_from and account_to balances.
     * If each step is success, wrote all changes to db.
     *
     * @throws \Exception
     */
    public function createTransaction(): void
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {

            if ((int)$this->account_to === (int)$this->account_from) {
                throw new \Exception('Operation aborted: Incoming and outgoing accounts are the same.');
            }

            $account_to = Account::findOne($this->account_to);
            if ($account_to !== null) {
                $account_to->balance += (float)$this->amount;
                $this->balance_after_to = $account_to->balance;
            } else {
                throw new \Exception('Operation aborted: Account_to does not exist');
            }

            $account_from = Account::findOne($this->account_from);
            if ($account_from !== null) {
                $account_from->balance -= (float)$this->amount;
                $this->balance_after_from = $account_from->balance;
            } else {
                throw new \Exception('Operation aborted: Account_from does not exist');
            }

            if (!$this->save()) {
                $ex = new \Exception('Operation aborted: Error on Transaction saving');
                throw $ex;
            }
            if (!$account_from->save()) {
                throw new \Exception('Operation aborted: Error on Account_from changes saving');
            }
            if (!$account_to->save()) {
                throw new \Exception('Operation aborted: Error on Account_to changes saving');
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
