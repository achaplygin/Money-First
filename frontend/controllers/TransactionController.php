<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\UserTransaction;


/**
 * Transaction controller
 */
class TransactionController extends Controller
{
    public function actionCreate()
    {
        $model = new UserTransaction();
        $model->user_id = Yii::$app->user->getId();

        if ($model->load(Yii::$app->request->post()) && $model->createUserTransaction()) {
            return $this->goHome();
        } else {

            return $this->render('create', [
                'model' => $model, 'message' => $model->createUserTransaction()
            ]);
        }
    }
}
