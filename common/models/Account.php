<?php

namespace common\models;

use Yii;

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
            'id' => 'ID',
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
     * todo No comments
     * @param int|null $accId
     * @return array
     */
    public function getSystemAccountList(int $accId = null)
    {
        return Account::find()
            ->select(["CONCAT('Account: ', account.id, ' of ', username) as account_label", 'account.id as account_id'])
            ->joinWith('user',false, 'JOIN')
            ->andWhere(['is_admin' => true])
            ->andFilterWhere(['account_id' => $accId])
            ->orderBy('account_id')
            ->indexBy('account_id')
            ->asArray(true)->column();
    }

    /**
     * todo No comments
     * @param int|null $accId
     * @return array
     */
    public function getAccountList(int $accId = null)
    {
        return Account::find()
            ->select(["CONCAT('Account: ', account.id, ' of ', username) as account_label", 'account.id as account_id'])
            ->joinWith('user',false, 'JOIN')
            ->andFilterWhere(['account_id' => $accId])
            ->orderBy('account_id')
            ->indexBy('account_id')
            ->asArray(true)->column();
    }

//    /**
//     * todo No comments
//     * @return string
//     */
//    public function getUsername() : ?string
//    {
//        if ($this->user_id !== null) {
//            return $this->user->username;
//        }
//        return null;
//    }
//
//    /**
//     * todo No comments
//     * @return string
//     */
//    public function getEmail() : string
//    {
//        return $this->user->email;
//    }
}
