<?php

namespace app\modules\vks\controllers\control;

use app\modules\vks\models\VksTypes;
use yii\web\Controller;

class VksToolsController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

}
