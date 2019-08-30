<?php

namespace app\models;

use app\services\ImportCsvService;
use Yii;
use yii\base\Model;

class ImportCsvForm extends Model
{
    public $csvFile;

    public function rules()
    {
        return [
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'csvFile' => 'Файл',
        ];
    }

    public function importFile()
    {
        $content = file_get_contents($this->csvFile->tempName);
        return ImportCsvService::importByContent($content);
    }
}
