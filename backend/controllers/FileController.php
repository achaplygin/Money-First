<?php


namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use backend\models\UploadForm;
use backend\models\TransactionImport;


class FileController extends Controller
{

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
