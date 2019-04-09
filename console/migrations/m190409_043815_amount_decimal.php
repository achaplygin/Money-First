<?php

use yii\db\Migration;

/**
 * Class m190409_043815_amount_decimal
 */
class m190409_043815_amount_decimal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('transaction', 'amount', 'decimal(42,2)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('transaction', 'amount', 'numeric(10)');
    }
}
