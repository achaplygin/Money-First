<?php

use yii\db\Migration;

/**
 * Class m190314_113003_auth_token
 */
class m190314_113003_auth_token extends Migration
{
    public function up()
    {
        $this->addColumn(
            'user',
            'auth_token', $this->string(43)
        );
    }

    public function down()
    {
        $this->dropColumn(
          'user',
          'auth_token'
        );
    }
}
