<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Account;

/**
 * AccountSearch represents the model behind the search form of `common\models\Account`.
 */
class AccountSearch extends Account
{
    public $username;
    public $email;
    public $minBalance;
    public $maxBalance;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['balance'], 'number'],
            [['username'], 'string'],
            [['email'], 'string'],
            [['minBalance', 'maxBalance'], 'number'],
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
        $query = self::find()->joinWith('user')->orderBy('user_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'account.id' => $this->id,
            'balance' => $this->balance,
            'user_id' => $this->user_id,
        ])
            ->andFilterWhere([
                '>', 'balance', $this->minBalance,
            ])
            ->andFilterWhere([
                '<', 'balance', $this->maxBalance,
            ])
            ->andFilterWhere([
                'ilike', 'username', $this->username,
            ])
            ->andFilterWhere([
                'ilike', 'email', $this->email,
            ]);

        return $dataProvider;
    }

    public function reset()
    {

    }

}
