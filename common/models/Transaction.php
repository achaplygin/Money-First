<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $amount
 * @property bool $is_incoming
 * @property int $user_id
 * @property int $account_id
 * @property string $balance_after_from
 * @property string $balance_after_to
 * @property string $created_at
 *
 * @property Account $account
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'balance_after_from', 'balance_after_to'], 'number'],
            [['is_incoming'], 'boolean'],
            [['user_id', 'account_id', 'balance_after_from', 'balance_after_to'], 'required'],
            [['user_id', 'account_id'], 'default', 'value' => null],
            [['user_id', 'account_id'], 'integer'],
            [['created_at'], 'safe'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'is_incoming' => 'Is Incoming',
            'user_id' => 'User ID',
            'account_id' => 'Account ID',
            'balance_after_from' => 'Balance After From',
            'balance_after_to' => 'Balance After To',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
