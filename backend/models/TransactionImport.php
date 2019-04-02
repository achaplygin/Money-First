<?php
/**
 *  todo больше комментариев!!!
 */

namespace backend\models;

use common\models\Account;
use common\models\CreateTransaction;
use Yii;
use common\models\User;
use common\models\Transaction;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use yii\base\Model;

/**
 * This is the model class for import "transactions" from file.
 *
 * @property string $amount
 * @property int $user_id
 * @property int $account
 * @property string $created_at
 *
 */
class TransactionImport extends Model
{

    public $amount;
    public $user_id;
    public $created_at;
    public $account;
    public $account_to;
    public $account_from;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'amount',
                    'user_id',
                    'account_from',
                    'account_to',
                    'created_at',
                ],
                'required',
            ],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
            [['user_id', 'account_from', 'account_to'], 'integer'],
            [['amount'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['amount', 'user_id', 'account', 'created_at'],
                function ($attribute) {
                    if (Transaction::find()
                        ->andWhere([
                            'amount' => $this->amount,
                            'user_id' => $this->user_id,
                            'created_at' => $this->created_at,
                            'account_to' => $this->account_to,
                            'account_from' => $this->account_from,
                        ])->exists()) {
                        $this->addError($attribute, 'Not uniq');
                    }
                }],
        ];
    }

    /**
     * @param string $fullpath Full path to file with filename.
     * @return array Data from file mapped by indexes from first line.
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public static function readFile(string $fullpath): array
    {
        $reader = new Xls();
        $spreadsheet = $reader->load($fullpath);

        $data = $spreadsheet->getActiveSheet()->toArray();
        $res = [];

        $h = array_shift($data);

        foreach ($data as $n => $item) {
            foreach ($item as $i => $value) {
                switch ($h[$i]) {
                    case 'user_id':
                        $res[$n]['user_id'] = (int)$value ?: null;

                        break;
                    case 'account_to':
                        if (!(int)$value == 0) {
                            $res[$n]['account_to'] = (int)$value;
                        } else {
                            $res[$n]['account_to'] = null;
                        }
                        break;
                    case 'account_from':
                        if (!(int)$value == 0) {
                            $res[$n]['account_from'] = (int)$value;
                        } else {
                            $res[$n]['account_from'] = null;
                        }
                        break;
                    case 'amount':
                        if (!$value == null) {
                            $res[$n]['amount'] = (float)$value;
                        } else {
                            $res[$n]['amount'] = $value;
                        }
                        break;
                    case 'created_at':
                        $res[$n]['created_at'] = (string)$value;
                        //date_format(date_create_from_format('Y-m-d H:i:s', $value), 'Y-m-d H:i:s');
                        break;

                    default:
                        break;
                }
            }
        }
        return $res;
    }

    /**
     * @param array $res
     */
    public static function import(array $res)
    {
        $message = ''; //for debug
        foreach ($res as $i => $item) {
            $model = new self();
            $model->attributes = $item;
            if (!$model->validate()) {
                $message = $message . '_fail:' . $i;    //for debug
            } else {
                $model->saveTransaction();
            }
        }

        Yii::$app->session->setFlash('error', $message); //for debug
    }

    public function saveTransaction()
    {
        // todo надо проверять права для from_to
//        try {
        $this->createUser($this->user_id);
        $this->createAccounts($this->account_to); //cka
        $model = new CreateTransaction();
        $model->attributes = $this->toArray();

        $model->createTransaction();
//            if (!) {
//                $err = $model->errors;
//                throw new \Exception("Can't save Transaction: " . json_encode($err));
//            }
//        } catch (\Exception $e) {
//
//        }
    }


    private function createUser(int $userId)
    {
        if (User::findOne($userId) === null) {
            // todo new User()
            new User();

        }
    }


    private function createAccounts(int $account)
    {
        if (Account::findOne($account) === null) {
            // todo new Account()
            new Account();

        }
    }
}
