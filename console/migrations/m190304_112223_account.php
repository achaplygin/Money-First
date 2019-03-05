<?php

use yii\db\Migration;

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
            'usr_id' => $this->integer()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'balance' => $this->decimal()->notNull()->defaultValue(0)->check('balance >= 0')
        ]);

        $this->addForeignKey(
            'fk-account-usr_id',
            'account',
            'usr_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%account}}');
    }

}
