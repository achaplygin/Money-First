<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;
use yii\db\ActiveQuery;

/**
 * TransactionSearch represents the model behind the search form of `common\models\Transaction`.
 *
 * @property string $minDate
 * @property string $maxDate
 * @property string $creator
 * @property string $userFrom
 * @property string $userTo
 * @property float $minAmount
 * @property float $maxAmount
 */
class TransactionSearch extends Transaction
{
    public $minDate;
    public $maxDate;
    public $creator;
    public $userFrom;
    public $userTo;
    public $minAmount;
    public $maxAmount;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'account_to', 'account_from'], 'integer'],
            [['amount', 'balance_after_from', 'balance_after_to', 'minAmount', 'maxAmount'], 'number'],
            [['created_at'], 'safe'],
            [['minDate', 'maxDate', 'creator', 'userFrom', 'userTo'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'Creator ID',
            'minDate' => 'Later Than',
            'maxDate' => 'Earlier Than',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Transaction::find()
            ->joinWith('user')
            ->joinWith('accountFrom accountFrom')
            ->joinWith('accountTo accountTo')
            ->joinWith(
                [
                'accountFrom accFrom' => function (ActiveQuery $query) {
                    $query->joinWith('user userFrom');
                },
                'accountTo accTo' => function (ActiveQuery $query) {
                    $query->joinWith('user userTo');
                }]
            )
            ->orderBy('transaction.created_at DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider(
            [
            'query' => $query,
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(
            [
            'amount' => $this->amount,
            'transaction.user_id' => $this->user_id,
            'account_to' => $this->account_to,
            'account_from' => $this->account_from,
            'created_at' => $this->created_at,
            ]
        )
            ->andFilterWhere(
                [
                '>=',
                'amount',
                $this->minAmount
                ]
            )
            ->andFilterWhere(
                [
                '<=',
                'amount',
                $this->maxAmount
                ]
            )
            ->andFilterWhere(
                [
                'ilike',
                'user.username',
                $this->creator
                ]
            )
            ->andFilterWhere(
                [
                'ilike',
                'userFrom.username',
                $this->userFrom
                ]
            )
            ->andFilterWhere(
                [
                'ilike',
                'userTo.username',
                $this->userTo
                ]
            )
            ->andFilterWhere(
                [
                '>=',
                'transaction.created_at',
                $this->minDate
                ]
            )
            ->andFilterWhere(
                [
                '<=',
                'transaction.created_at',
                $this->maxDate
                ]
            );

        return $dataProvider;
    }
}