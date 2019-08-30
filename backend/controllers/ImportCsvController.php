<?php


namespace app\controllers;

use app\models\ImportCsvForm;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\helpers\Url;
use Yii;

class ImportCsvController extends Controller
{
    public function actionIndex()
    {
        $model = new ImportCsvForm();
        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
            if ($model->importFile()) {
                $this->redirect(Url::to('/'));
            } else {
                $this->redirect('index');
            }
        } else {
            return $this->render('index', ['model' => $model]);
        }
    }
}
