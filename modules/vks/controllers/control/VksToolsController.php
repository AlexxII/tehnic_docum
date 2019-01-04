<?php

namespace app\modules\vks\controllers\control;

use app\modules\vks\models\VksTools;
use app\modules\vks\models\VksTypes;
use yii\web\Controller;

class VksToolsController extends Controller
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionTools()
  {
    $id = VksTools::find()->select('id, rgt, lft, root')->where(['=', 'lvl', 0])->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = VksTools::findOne($id)->tree();
    return json_encode($roots);
  }

  public function actionVksToolsCreate($parentTitle, $title)
  {
    $data = [];
    $category = VksTools::findOne(['name' => $parentTitle]);
    $newSubcat = new VksTools(['name' => $title]);
    $newSubcat->parent_id = $category->id;
    $newSubcat->appendTo($category);
    $data['acceptedTitle'] = $title;
    return json_encode($data);
  }

  public function actionCreateRoot($title)
  {
    \Yii::$app->db->schema->refresh();
    $newRoot = new VksTools(['name' => $title]);
    $result = $newRoot->makeRoot();
    if ($result) {
      $data['acceptedTitle'] = $title;
      return json_encode($data);
    } else {
      return var_dump('0');
    }
  }

  public function actionUpdate($id, $title)
  {
    $category = VksTools::findOne(['id' => $id]);
    $category->name = $title;
    $category->save();
    return true;
  }

  public function actionMove($item, $action, $second, $parent)
  {
    $item_model = VksTools::findOne($item);
    $second_model = VksTools::findOne($second);
    switch ($action) {
      case 'after':
        $item_model->insertAfter($second_model);
        break;
      case 'before':
        $item_model->insertBefore($second_model);
        break;
      case 'over':
        $item_model->appendTo($second_model);
        break;
    }
    $parent = VksTools::findOne(['name' => $parent]);
    $item_model->parent_id = $parent->id;
    if ($item_model->save()) {
      return true;
    }
    return false;
  }

  public function actionDelete()
  {
    if (!empty($_POST)) {
      // TODO: удаление или невидимый !!!!!!!
      $id = $_POST['id'];
      $category = VksTools::findOne(['id' => $id]);
      $category->delete();
    }
  }

  public function actionDeleteRoot()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $root = VksTools::findOne(['id' => $id]);
    }
    $root->deleteWithChildren();
  }

  public function actionComplex()
  {

  }

  public function actionSurnames($id)
  {
    $model = VksTools::findOne(['id' => $id]);
    return json_encode($model->surnames);
  }

  public function actionSurnamesSave()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $model = VksTools::findOne(['id' => $id]);
      $model->surnames = $_POST['Data'];
      if ($model->save()) {
        return true;
      }
      return false;
    }
  }
}
