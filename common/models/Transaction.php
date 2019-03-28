<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
            [['is_incoming'], 'boolean'],
            [['amount', 'user_id', 'account_from', 'account_to', 'balance_after_from', 'balance_after_to'], 'required'],
            [['user_id', 'account_from', 'account_to'], 'default', 'value' => null],
            [['user_id', 'account_from', 'account_to'], 'integer'],
            [['created_at'], 'safe'],
            [['account_from'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['account_from' => 'id']],
            [['account_to'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['account_to' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

            ['amount', function ($attribute) {
                if ($this->accountFrom->balance < $this->$attribute) {
                    $this->addError($attribute, 'Not enough money.');
                };
            }],
        ];
    }

//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//
//        // todo: разобраться со сраными поведениями!!!11!1адын!!!11
//        $behaviors[] = [
//            'class' => TimestampBehavior::class,
//            'value' => function () {
//                return date('Y-m-d H:i:s', time());
//            },
//        ];
//
//        return $behaviors;
//    }

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
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isIncome(User $user): bool
    {
        return $this->account_to === $user->account->id;
    }
}
