<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Subcategory;
use app\modules\tehdoc\models\Equipment;
use app\modules\admin\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['superAdmin'],      // доступ только с ролью superAdmin
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPlacement()
    {
        return $this->render('places');
    }

    public function actionTests()
    {
        return $this->render('tests');
    }
}