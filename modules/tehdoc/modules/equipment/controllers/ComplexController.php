<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use app\modules\tehdoc\models\Images;
use app\modules\tehdoc\modules\equipment\models\Complex;
use app\modules\tehdoc\modules\equipment\models\Tools;
use yii\web\Controller;

class ComplexController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $modelComplex = new Complex();
        $modelsTool = [new Tools];
        $fUpLoad = [new Images];
        return $this->render('create', [
            'modelComplex' => $modelComplex,
            'modelsTool' => (empty($modelsTool)) ? [new Tools] : $modelsTool,
            'fUpload' => (empty($fUpLoad)) ? [new Images] : $fUpLoad
        ]);
    }
}