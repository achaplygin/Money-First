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
            'account_user' => $this->integer()->notNull(),
            'account_system' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultValue('now()'),
        ]);

        $this->addForeignKey(
            'fk-transaction-account_user_id',
            'transaction',
            'account_user',
            'account',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-transaction-account_system_id',
            'transaction',
            'account_system',
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
        $this->dropForeignKey('fk-transaction-account_user_id', 'transaction');
        $this->dropForeignKey('fk-transaction-account_system_id', 'transaction');
        $this->dropTable('{{%transaction}}');
    }

}