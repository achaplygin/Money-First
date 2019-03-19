<?php

use yii\db\Migration;
use \common\models\User;

/**
 * Class m190304_112223_account
 */
class m190304_112223_account extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'balance' => $this->decimal()->notNull()->defaultValue(0)->check('balance >= 0')
        ]);

        $this->addForeignKey(
            'fk-account-usr_id',
            'account',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        $admin = User::findByUsername('admin');
        $this->insert('account', [
            'user_id' => $admin->getId(),
            'balance' => 1000000,
        ]);
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropForeignKey('fk-account-usr_id', 'transaction');
        $this->dropTable('{{%account}}');
    }

}
