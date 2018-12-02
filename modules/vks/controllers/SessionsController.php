<?php

namespace app\modules\vks\controllers;

use app\modules\vks\models\VksSessions;
use Yii;
use yii\web\Controller;

class SessionsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new VksSessions();
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionConfirm()
    {
        $model = new VksSessions();
        return $this->render('confirm', [
            'model' => $model
        ]);
    }
}