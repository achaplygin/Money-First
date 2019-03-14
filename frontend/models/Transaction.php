<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $amount
 * @property bool $is_incoming
 * @property int $account_user
 * @property int $account_system
 * @property string $created_at
 *
 * @property Account $accountUser
 * @property Account $accountSystem
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
            [['amount'], 'number'],
            [['is_incoming'], 'boolean'],
            [['account_user', 'account_system'], 'required'],
            [['account_user', 'account_system'], 'default', 'value' => null],
            [['account_user', 'account_system'], 'integer'],
            [['created_at'], 'safe'],
            [['account_user'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_user' => 'id']],
            [['account_system'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_system' => 'id']],
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
            'account_user' => 'Account User',
            'account_system' => 'Account System',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountUser()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountSystem()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_system']);
    }
}
