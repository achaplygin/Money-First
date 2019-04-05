<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Transaction;
use yii\web\NotFoundHttpException;
use common\models\CreateTransaction;
use backend\models\TransactionSearch;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function () {
                            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin) {
                                return true;
                            }
                            return false;
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaction models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pagesize' => 10];
        $dataProvider->sort = false;

        return $this->render(
            'index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the transactions page.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model = new CreateTransaction();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            try {
                $model->createTransaction();
                Yii::$app->session->setFlash('createUserTransaction', 'ok');
                return $this->redirect('/transaction');
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('createUserTransaction', $e->getMessage());
            }
        } else {
            Yii::$app->session->setFlash('createUserTransaction', 'Please fill out the following form');
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
