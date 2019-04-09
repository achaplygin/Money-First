<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Account;
use common\models\Transaction;
use common\models\CreateTransaction;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

/**
 * Class TransactionImport
 *
 * This is the model class for import "transactions" from file.
 * In this class realised:
 *  -Read data from xls file
 *  -Mapping array by required indexes
 *  -Validation of the received information
 *  -Creating relevant users and accounts if required.
 *  -Calling a method to create a transaction.
 *
 * @property float $amount;
 * @property string $created_at;
 * @property int $account;
 * @property bool $is_income;
 * @property int $account_to
 * @property int $account_from
 *
 * @package backend\models
 */
class TransactionImport extends Model
{

    public $amount;
    public $created_at;
    public $account;
    public $is_income;
    public $account_to;
    public $account_from;

    /**
     * Rules for validate parsed data from file
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['amount', 'account_from', 'account_to', 'created_at', 'is_income',], 'required',],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
            [['is_income'], 'boolean'],
            [['account_from', 'account_to'], 'integer'],
            [['amount'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['amount', 'account', 'created_at'],
                function ($attribute) {
                    if (Transaction::find()->andWhere(
                        [
                            'amount' => $this->amount,
                            'created_at' => $this->created_at,
                            'account_to' => $this->account_to,
                            'account_from' => $this->account_from,
                            ]
                    )->exists()
                    ) {
                        $this->addError($attribute, 'Not uniq');
                    }
                }],
        ];
    }

    /**
     * @param  string $fullpath - Full path to uploaded file.
     * @return array - The array of the required data mapped by first line indexes.
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public static function readFile(string $fullpath): array
    {
        $reader = new Xls();
        $spreadsheet = $reader->load($fullpath);

        $data = $spreadsheet->getActiveSheet()->toArray();
        $res = [];

        $keys = array_shift($data);

        foreach ($data as $n => $item) {
            foreach ($item as $i => $value) {
                switch ($keys[$i]) {
                case 'account_to':
                    $res[$n]['account_to'] = (int)$value ?: null;
                    break;
                case 'account_from':
                    $res[$n]['account_from'] = (int)$value ?: null;
                    break;
                case 'amount':
                    $res[$n]['amount'] = (float) str_replace(',', '.', $value) ?: null;
                    break;
                case 'created_at':
                    $res[$n]['created_at'] = (string)$value ?: null;
                    //date_format(date_create_from_format('Y-m-d H:i:s', $value), 'Y-m-d H:i:s');
                    break;
                case 'is_income':
                    $res[$n]['is_income'] = (bool)$value;
                    break;

                default:
                    break;
                }
            }
        }
        return $res;
    }

    /**
     * This function validate each line from array and launch process of creating transaction.
     *
     * @param  array $res - Mapped array of the required data.
     * @throws \Exception
     */
    public static function import(array $res)
    {
        $message = 'Those lines from file was not passed validation: ';
        foreach ($res as $i => $item) {
            $model = new self();
            $model->attributes = $item;

            if ($model->validate()) {
                $message = $message.'_|_'.$i.'_it:_'.$item['amount'].'_';
                $message = $message.'_|_'.$i.'_mo:_'.var_dump($model->amount).'_';
                Yii::$app->session->setFlash('info', $message);
                $model->saveTransaction();
            } else {
                $strNum = $i + 2;
                $message = $message . $strNum . ', ';
                Yii::$app->session->setFlash('warning', $message);
            }
        }
    }

    /**
     * Calling necessary functions to create user, account, transaction.
     *
     * @throws \Exception
     */
    public function saveTransaction()
    {

        $this->createAccounts($this->account_from, $this->account_to, $this->is_income);

        $model = new CreateTransaction();
        $model->attributes = $this->toArray();
        $model->user_id = Yii::$app->user->identity->id;

        try {
            $model->createTransaction();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

    }

    /**
     * Matching of outgoing and target accounts with existing ones, or the creation of appropriate new ones.
     *
     * @param  int  $account_from
     * @param  int  $account_to
     * @param  bool $isIncome
     * @throws \yii\base\Exception
     */
    private function createAccounts(int $account_from, int $account_to, bool $isIncome)
    {
        $accFrom = Account::findOne($account_from);
        $accTo = Account::findOne($account_to);

        if ($isIncome) {
            //для входящих операций

            //пользовательский счёт:
            // -если не существует
            // --создаём пользователя
            // --afterSave() создаёт ему счёт
            // --подставляем созданному счёту id из файла
            if ($accFrom === null) {
                $user_from = $this->createUser();
                $user_from->account->id = $account_from;
                $user_from->account->save();
            }

            //целевой счёт:
            // -если не существует - создаём счёт админу.
            // -если существует - проверяем, что админский.
            if ($accTo === null) {
                $accTo = new Account(
                    [
                    'id' => $account_to,
                    'user_id' => User::findOne(['username' => 'admin'])->id,
                    'balance' => 0,
                    ]
                );
                $accTo->save();
            } else {
                if (!$accTo->user->is_admin) {
                    throw new \Exception('Incoming operation cannot be credited to the user account.');
                }
            }

        } else {
            //для исходящих операций

            // системный счёт
            // -если не существует - создаём счёт админу.
            // -если существует - проверяем, что админский.
            if ($accFrom === null) {
                $accFrom = new Account(
                    [
                    'id' => $account_from,
                    'user_id' => User::findOne(['username' => 'admin'])->id,
                    'balance' => $this->amount,
                    ]
                );
                $accFrom->save();
            } else {
                if (!$accFrom->user->is_admin) {
                    throw new \Exception('Outgoing operation cannot be credited from the user account.');
                }
            }
            //целевой пользовательский счёт
            // -если не существует
            // --создаём пользователя
            // --afterSave() создаёт ему счёт
            // --подставляем созданному счёту id из файла
            if ($accTo === null) {
                $user_to = $this->createUser();
                $user_to->account->id = $account_to;
                $user_to->account->save();
            }
        }
    }

    /**
     * Creating new user with generated name and default password.
     *
     * @return User
     * @throws \yii\base\Exception
     */
    private function createUser(): User
    {
        $num = User::find()->count();
        if (User::findOne(['username' => 'user' . $num])
            || User::findOne(['email' => 'user' . $num . '@mail.com'])
        ) {
            $num = $num . '_' . Yii::$app->security->generateRandomString(3);
        }
        $username = 'user' . $num;
        $email = 'user' . $num . '@mail.com';
        $password = '123456';

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
