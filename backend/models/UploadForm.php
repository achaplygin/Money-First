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

    /**
     * Validate rules for uploaded file type
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['xlsFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls'],
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        $path = __DIR__ . '/../web/uploads/';
        $this->fullPath = $path . time() . '_' . $this->xlsFile->baseName . '.' . $this->xlsFile->extension;
        if ($this->validate()) {
            $this->xlsFile->saveAs($this->fullPath);
            return true;
        } else {
            return false;
        }
    }
}
