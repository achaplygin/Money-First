<?php


namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\UploadForm;
use backend\models\TransactionImport;


class FileController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Get file and pass it for importing transactions.
     *
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->xlsFile = UploadedFile::getInstance($model, 'xlsFile');
            if ($model->upload()) {
                // file is uploaded successfully
                TransactionImport::import(TransactionImport::readFile($model->fullPath));

                Yii::$app->session->setFlash('success', 'File was parsed. Validated operations was saved.');
                return $this->render('upload', ['model' => $model]);
            }
        }
        return $this->render('upload', ['model' => $model]);
    }

}
