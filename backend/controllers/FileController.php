<?php


namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use backend\models\UploadForm;
use backend\models\TransactionImport;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class FileController extends Controller
{

    /**
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

//                Yii::$app->session->setFlash('success', 'ok');
                return $this->render('upload', ['model' => $model]);
            }
        }
        return $this->render('upload', ['model' => $model]);
    }

    /**
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function actionRead()
    {
        $reader = new Xls();
        $spreadsheet = $reader->load(realpath(dirname(__FILE__)) . '/../web/uploads/1553592401_transactions.xls');

        return $this->render('read-file', ['spreadsheet' => $spreadsheet]);
    }

}
