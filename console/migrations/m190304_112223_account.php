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
            'balance' => $this->decimal()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'fk-account-usr_id',
            'account',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $admin = new User();
        $admin->username = 'admin';
        $admin->email = 'admin@example.com';
        $admin->setPassword('123456');
        $admin->generateAuthKey();
        $admin->save();

        $this->update('{{%user}}', [
            'is_admin' => true
        ], "username='admin'");

        $this->update(
            'account',
            ['balance' => 1e6],
            ['user_id' => $admin->id]
        );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropForeignKey('fk-account-usr_id', 'account');
        $this->dropTable('{{%account}}');
    }

}
