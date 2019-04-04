<?php

namespace common\models;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property int $user_id
 * @property string $balance
 *
 * @property User $user
 * @property Transaction[] $transactionsFromAccount
 * @property Transaction[] $transactionsToAccount
 */
class Account extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['balance'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Account ID',
            'user_id' => 'User ID',
            'balance' => 'Balance',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsFromAccount()
    {
        return $this->hasMany(Transaction::class, ['account_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsToAccount()
    {
        return $this->hasMany(Transaction::class, ['account_to' => 'id']);
    }

    /**
     * Get list of accounts in human-friendly format, indexed by account_id.
     *
     * @param bool|null $isAdmin If true - only system account will returned.
     * @param int|null $accId Result just for this account.
     * @return array
     */
    public function getAccountList(bool $isAdmin = null, int $accId = null): array
    {
        return Account::find()
            ->select(["CONCAT('Account: ', account.id, ' of ', username) as account_label", 'account.id as account_id'])
            ->joinWith('user', false, 'JOIN')
            ->andFilterWhere(['is_admin' => $isAdmin])
            ->andFilterWhere(['account_id' => $accId])
            ->orderBy('account_id')
            ->indexBy('account_id')
            ->asArray(true)->column();
    }

}
