<?php

namespace app\modules\vks\controllers;

use app\modules\tehdoc\models\Equipment;


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
        $model = new Equipment();
        return $this->render('create',[
            'model' => $model
        ]);
    }
}