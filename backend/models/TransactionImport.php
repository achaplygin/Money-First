<?php
/**
 *
 */

namespace backend\models;

use Yii;
use common\models\User;
use common\models\Transaction;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use yii\base\Model;

/**
 * This is the model class for import "transactions" from file.
 *
 * @property string $amount
 * @property bool $is_incoming
 * @property int $user_id
 * @property int $account
 * @property string $created_at
 *
 */
class TransactionImport extends Model
{

    public $amount;
    public $is_incoming;
    public $user_id;
    public $created_at;
    public $account;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['amount', 'user_id', 'account', 'is_incoming', 'created_at'], 'required'],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
            [['is_incoming'], 'boolean'],
            [['user_id', 'account'], 'integer'],
            [['amount'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['amount', 'user_id', 'account', 'is_incoming', 'created_at'],
                function ($attribute) {
                    if (Transaction::find()
                        ->andWhere([
                            'amount' => $this->amount,
                            'user_id' => $this->user_id,
                            'is_incoming' => $this->is_incoming,
                            'created_at' => $this->created_at,
                            $this->is_incoming ? 'account_to' : 'account_from' => $this->account,
                            $this->is_incoming ? "account_from" : "account_to" =>
                                User::findOne($this->user_id) ? User::findOne($this->user_id)->account : null,
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

        foreach ($data as $n => $item) {
            if ($n === 0) continue;
            foreach ($item as $i => $value) {
                if (!$data[0][$i] == null) {
                    switch ($data[0][$i]) {
                        case 'user_id':
                            if (!(int)$value == 0) {
                                $res[$n]['user_id'] = (int)$value;
                            } else $res[$n]['user_id'] = null;
                            break;
                        case 'account':
                            if (!(int)$value == 0) {
                                $res[$n]['account'] = (int)$value;
                            } else $res[$n]['account'] = null;
                            break;
                        case 'amount':
                            if (!$value == null) {
                                $res[$n]['amount'] = (float)$value;
                            } else $res[$n]['amount'] = $value;
                            break;
                        case 'is_incoming':
                            $res[$n]['is_incoming'] = (bool)$value;
                            break;
                        case 'created_at':
                            $res[$n]['created_at'] = (string)$value;
                            //date_format(date_create_from_format('Y-m-d H:i:s', $value), 'Y-m-d H:i:s');
                            break;
                    }
                }
            }
        }
        return $res;
    }

    /**
     * @param array $res
     * @throws \Exception
     */
    public static function import(array $res)
    {
        $message = '';
        foreach ($res as $i => $item) {
            $model = new TransactionImport();
            $model->attributes = $item;
            if (!$model->validate()) $message = $message . '_fail:' . $i;
        }
        Yii::$app->session->setFlash('error', $message);

    }

    public function save()
    {
        $model = new Transaction();
        $model->attributes = $this; // todo так не будет работать, надо разрулить from_to
    }

}
