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
 * @property int $account_from
 * @property int $account_to
 * @property string $balance_after_from
 * @property string $balance_after_to
 * @property string $created_at
 *
 * @property Account $accountFrom
 * @property Account $accountTo
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
            [['amount'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            ['amount', function ($attribute, $params, $validator) {
                if (Yii::$app->user->identity->account->balance < $this->$attribute) {
                    $this->addError($attribute, 'No money.');
                };
            }],
            [['is_incoming'], 'boolean'],
            [['user_id', 'account_from', 'account_to', 'balance_after_from', 'balance_after_to'], 'required'],
            [['user_id', 'account_from', 'account_to'], 'default', 'value' => null],
            [['user_id', 'account_from', 'account_to'], 'integer'],
            [['created_at'], 'safe'],
            [['account_from'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_from' => 'id']],
            [['account_to'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_to' => 'id']],
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
            'account_from' => 'Account From',
            'account_to' => 'Account To',
            'balance_after_from' => 'Balance After From',
            'balance_after_to' => 'Balance After To',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountFrom()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountTo()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
