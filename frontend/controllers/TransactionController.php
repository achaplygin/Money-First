<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Account;
use yii\web\ForbiddenHttpException;
use common\models\CreateTransaction;

/**
 * Transaction controller
 */
class TransactionController extends Controller
{
    /**
     * todo написать пару слов о создании транзакций
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        /** @var \common\models\User $usr */
        $usr = Yii::$app->user->identity;

        $model = new CreateTransaction();
        $model->user_id = Yii::$app->user->id;
        $model->account_from = $usr->account->id;

        if ($model->load(Yii::$app->request->post())) {
            try {
                if (!Account::findOne($model->account_to)->user->is_admin) {
                    throw new ForbiddenHttpException('Вы не можете переводить средства на счёт другого контрагента');
                }
                $model->createTransaction();
                Yii::$app->session->setFlash('createUserTransaction', 'ok');
                return $this->goBack();
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('createUserTransaction', $e->getMessage());
            }
        } else {
            Yii::$app->session->setFlash('createUserTransaction', 'Please fill out the following form');
        }
        return $this->render('create', ['model' => $model]);
    }
}
