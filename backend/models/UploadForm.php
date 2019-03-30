<?php

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $xlsFile;
    public $fullPath;

    public function rules()
    {
        return [
            [['xlsFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls'],
            //'xlsFile' => 'application/vnd.ms-excel'
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
//        __DIR__
        $path = realpath(dirname(__FILE__)) . '/../web/uploads/';
        $this->fullPath = $path . time() . '_' . $this->xlsFile->baseName . '.' . $this->xlsFile->extension;
        if ($this->validate()) {
            $this->xlsFile->saveAs($this->fullPath);
            return true;
        } else {
            return false;
        }
    }
}
