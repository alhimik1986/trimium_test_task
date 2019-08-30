<?php


namespace app\controllers;

use yii\web\Controller;
use Yii;

class RestController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->request->isGet) {
            return call_user_func([$this, 'methodGet'], func_get_args());
        } elseif (Yii::$app->request->isPost) {
            return call_user_func([$this, 'methodPost'], func_get_args());
        } elseif (Yii::$app->request->isPut) {
            return call_user_func([$this, 'methodPut'], func_get_args());
        } elseif (Yii::$app->request->isPatch) {
            return call_user_func([$this, 'methodPatch'], func_get_args());
        } elseif (Yii::$app->request->isDelete) {
            return call_user_func([$this, 'methodDelete'], func_get_args());
        }
    }

    public function methodGet()
    {

    }

    public function methodPost()
    {

    }

    public function methodPut()
    {

    }

    public function methodPatch()
    {

    }

    public function methodDelete()
    {

    }
}
