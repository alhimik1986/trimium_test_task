<?php
namespace app\commands;

use app\services\ImportCsvService;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;


class ImportCsvController extends Controller
{
    public function actionIndex()
    {
        $app_path = Yii::getAlias('@app');
        $content = file_get_contents($app_path.'/../import.csv');
        ImportCsvService::importByContent($content);
        return ExitCode::OK;
    }
}
