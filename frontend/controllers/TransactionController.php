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
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            try {
                $model->createUserTransaction();
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
