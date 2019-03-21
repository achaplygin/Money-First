<?php

use yii\db\Migration;

/**
 * Class m190314_053711_transaction
 */
class m190314_053711_transaction extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable('{{%transaction}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->decimal()->notNull()->defaultValue(0)->check('amount >= 0'),
            'is_incoming' => $this->boolean()->notNull()->defaultValue(true),
            'user_id' => $this->integer()->notNull(),
            'account_from' => $this->integer()->notNull(),
            'account_to' => $this->integer()->notNull(),
            'balance_after_from' => $this->decimal()->notNull()->check('amount >= 0'),
            'balance_after_to' => $this->decimal()->notNull()->check('amount >= 0'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('now()'),
        ]);

        $this->addForeignKey(
            'fk-transaction-user_id',
            'transaction',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-transaction-account_to',
            'transaction',
            'account_to',
            'account',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-transaction-account_from',
            'transaction',
            'account_from',
            'account',
            'id',
            'CASCADE'
        );

    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropForeignKey('fk-transaction-user_id', 'transaction');
        $this->dropForeignKey('fk-transaction-account_to', 'transaction');
        $this->dropForeignKey('fk-transaction-account_from', 'transaction');
        $this->dropTable('{{%transaction}}');
    }

}
