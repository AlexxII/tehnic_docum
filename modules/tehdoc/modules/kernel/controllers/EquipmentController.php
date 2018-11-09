<?php

namespace app\modules\tehdoc\modules\kernel\controllers;

use app\modules\admin\models\Category;
use app\modules\admin\models\Classifier;
use app\modules\admin\models\Placement;
use app\modules\tehdoc\modules\kernel\models\Equipment;
use app\modules\tehdoc\modules\kernel\models\SSP;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\tehdoc\models\Images;
use yii\web\UploadedFile;
use yii\db\mssql\PDO;
use yii\base\DynamicModel;

class EquipmentController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionCreate()
  {
    $model = new Equipment();
    $fUpload = new Images();
    $model->quantity = 1;                             // По умолчанию, кол-во оборудования - 1

    if ($model->load(Yii::$app->request->post())) {
      $model->id_eq = rand();
      if ($model->save()) {
        if ($fUpload->load(Yii::$app->request->post())) {
          $fUpload->imageFiles = UploadedFile::getInstances($fUpload, 'imageFiles');
          if ($fUpload->uploadImage($model->id_eq)) {
            Yii::$app->session->setFlash('success', 'Оборудование добавлено');
          } else {
            Yii::$app->session->setFlash('error', 'Оборудование добавлено, но не загружены изображения');
          }
        } else {
          Yii::$app->session->setFlash('success', 'Оборудование добавлено');
        }
        return $this->redirect(['view', 'id' => $model->id_eq]);
      } else {
        Yii::$app->session->setFlash('success', 'Ошибка валидации');
      }
    }
    return $this->render('create', [
        'model' => $model,
        'fupload' => $fUpload

    ]);
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $fUpload = new Images();

    if ($model->load(Yii::$app->request->post())) {
      if ($model->save(false)) { // TODO Разобраться с валидацией, при вкл - не сохраняет
        if ($fUpload->load(Yii::$app->request->post())) {
          $fUpload->imageFiles = UploadedFile::getInstances($fUpload, 'imageFiles');
          if ($fUpload->uploadImage($model->id_eq)) {
            Yii::$app->session->setFlash('success', 'Изменения внесены');
          }
        } else {
          Yii::$app->session->setFlash('success', 'Изменения внесены!!');
        }
        return $this->redirect(['view', 'id' => $model->id]);
      } else {
        Yii::$app->session->setFlash('error', 'Изменения НЕ внесены');
      }
    }

    return $this->render('update', [
        'model' => $model,
        'fupload' => $fUpload,
    ]);
  }

  public function actionAbout($id)
  {
    return $this->renderPartial('about', [
        'model' => $this->findModel($id),
    ]);
  }

  public function actionView($id)
  {
    return $this->render('view', [
        'model' => $this->findModel($id),
    ]);
  }

  protected function findModel($id)
  {
    if (($model = Equipment::find()->where(['id_eq' => $id])->limit(1)->all()) !== null) {
      if (!empty($model)) {
        return $model[0];
      }
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

  public function actionCategories()
  {
    return $this->render('categories');
  }

  public function actionClassifiers()
  {
    return $this->render('classifiers');
  }

  public function actionPlacement()
  {
    return $this->render('placements');
  }

  public function actionServerSide()
  {
    $table = 'equipment_tbl';
    $primaryKey = 'id';
    $columns = array(
        array('db' => 'id_eq', 'dt' => 0),
        array('db' => 'eq_title', 'dt' => 1),
        array('db' => 'eq_manufact', 'dt' => 2),
        array('db' => 'eq_model', 'dt' => 3),
        array('db' => 'eq_serial', 'dt' => 4),
        array(
            'db' => 'eq_factdate',
            'dt' => 5,
            'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
              return date('jS M y', strtotime($d));
            }
        ),
        array(
            'db' => 'quantity',
            'dt' => 6,
        )
    );

    $sql_details = \Yii::$app->params['sql_details'];

    if (isset($_GET['lft'])) {
      if ($_GET['lft']) {
        $lft = (int)$_GET['lft'];
        $rgt = (int)$_GET['rgt'];
        $table_ex = (string)$_GET['db_tbl'];
        $identifier = (string)$_GET['identifier'];
        $where = ' ' . $identifier . ' in (SELECT id
    FROM ' . $table_ex . '
      WHERE ' . $table_ex . '.lft >= ' . $lft . '
        AND ' . $table_ex . '.rgt <= ' . $rgt . ')';
        return json_encode(
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, $where)
        );
      }
    }
    return json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
    );
  }

//=============== Серверная часть работы с классификатором ==============================================================

  public function actionDisplayColumns($id)
  {
    $clsf = Classifier::findOne($id);
    $tableScheme = json_decode($clsf->clsf_table_scheme);

    if (empty($tableScheme->columns)){
      $columns = ['id', 'Наименование', 'Производитель/Модель', 'Модель', 's/n', 'Action', ''];
    } else {
      foreach ($tableScheme->columns as $column) {
        $columns[] = $column->label;
      }
      array_unshift($columns, 'id', 'Наименование', 'Производитель/Модель', 'Модель', 's/n');
      array_push($columns, 'Action', '');
    }
    $data = array();
    $data = [
        "columns" => $columns
    ];
    return json_encode($data);
  }


  public function actionServerSideEx($id)
  {
    $sql_details = \Yii::$app->params['sql_details'];
    $table = 'equipment_tbl';                                 // основная таблица с оборудованием
    $primaryKey = 'id_eq';

    $clsf = Classifier::findOne($id);
    $tableScheme = json_decode($clsf->clsf_table_scheme);

    if (!$tableScheme){
      $sql = "SELECT COUNT(`{$primaryKey}`)
			 FROM `$table`";
      $db = SSP::sql_connect($sql_details);
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $data = $stmt->fetchAll( PDO::FETCH_BOTH );

      return json_encode(array(                             // возврат "Записи отсутствуют, если нет таблицы в БД
          'draw' => 1,
          'recordsTotal' => $data[0][0],
          'recordsFiltered' => 0,
          'data' => []
      ));
    }

    $tableTwo = $tableScheme->tableName;
    $columns = array(                                         // колонки из основной таблицы оборудования
        array('db' => 'id_eq', 'dt' => 0),
        array('db' => 'eq_title', 'dt' => 1),
        array('db' => 'eq_manufact', 'dt' => 2),
        array('db' => 'eq_model', 'dt' => 3),
        array('db' => 'eq_serial', 'dt' => 4),
    );

    if (!empty($tableScheme)) {                           // формируется запрос, если классификатор сложный
      $i = 5;                                             // простой классификатор просто хранит перечень техники
      foreach ($tableScheme->columns as $column) {
        $temp = array();
        $temp['db'] = $column->name;
        $temp['dt'] = $i++;
        $columns[] = $temp;
      }
    }
    return json_encode(
        SSP::simpleEx($_GET, $sql_details, $table, $primaryKey, $columns, $tableTwo)
    );
  }


  public function actionDelete()
  {
    $report = true;
    foreach ($_POST['jsonData'] as $d) {
      $model = $this->findModel($d);
      $report = $model->delete();
    }
    if ($report) {
      return true;
    }
    return false;
  }


}