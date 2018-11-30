<?php

namespace app\modules\vks\controllers;

use Yii;
use yii\web\Controller;

class ControlController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}