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

    public function actionVksType()
    {
        return $this->render('vks-type');
    }

    public function actionVksPlace()
    {
        return $this->render('vks-place');
    }

    public function actionVksSubscribers()
    {
        return $this->render('vks-subscribes');
    }

    public function actionVksOrder()
    {
        return $this->render('vks-order');
    }

    public function actionVksEmployee()
    {
        return $this->render('vks-employee');
    }

    public function actionVksEquipment()
    {
        return $this->render('vks-employee');
    }

}