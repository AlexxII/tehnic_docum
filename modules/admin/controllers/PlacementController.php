<?php

namespace app\modules\admin\controllers;


use app\modules\admin\models\Placement;
use app\modules\tehdoc\modules\kernel\models\Equipment;
use yii\web\Controller;

class PlacementController extends Controller
{

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionPlacements()
  {
    $id = Placement::find()->select('id, lft, rgt')->where(['=', 'lvl', 0])->all();
    if (!$id) {
      $data = array();
      $data = [['title' => 'База данных пуста', 'key' => -999]];
      return json_encode($data);
    }
    $roots = Placement::findOne($id)->tree();
    return json_encode($roots);
  }

  public function actionMove ($item,$action,$second)
  {
    $item_model = Placement::findOne($item);
    $second_model = Placement::findOne($second);
    switch ($action){
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
    $parent = Placement::findOne($second);
    if (!$parent->children()->one()){
      $parent->disabled = 0;
      $parent->save();
    } else {
      $parent->disabled = 1;
      $parent->save();
    }
    if ($item_model->save()) {
      return true;
    }
    return false;
  }

  public function actionCreate($parentTitle, $title)
  {
    $data = [];
    $category = Placement::findOne(['name' => $parentTitle]);
    $newSubcat = new Placement(['name' => $title]);
    $newSubcat->root = $category->id;
    $newSubcat->appendTo($category);
    if ($parent = $newSubcat->parents(1)->one()){
      $parent->disabled = 1;
      $parent->save();
    }
    $data['acceptedTitle'] = $title;
    return json_encode($data);
  }

  public function actionCreateRoot($title)
  {
    $newRoot = new Placement(['name' => $title]);
    $newRoot->makeRoot();
    $data['acceptedTitle'] = $title;
    return json_encode($data);
  }

  public function actionUpdate($id, $title)
  {
    $category = Placement::findOne(['id' => $id]);
    $category->name = $title;
    $category->save();
    return true;
  }

  public function actionDelete($id)
  {
    // TODO: удаление или невидимый !!!!!!!
    $category = Placement::findOne(['id' => $id]);
    $parent = $category->parents(1)->one();
    $category->delete();
    if (!$parent->children()->one()){
      $parent->disabled = 0;
      $parent->save();
    } else {
      $parent->disabled = 1;
      $parent->save();
    }
  }

  public function actionDeleteRoot($id)
  {
    $root = Placement::findOne(['id' => $id]);
    $root->deleteWithChildren();
  }

  public function actionTests()
  {
    $array = array();
    $leaves = Placement::find()->select('id')->leaves()->orderBy('lft')->asArray()->all();
    $categories = Placement::find()->select('id')->where(['!=', 'lvl', '0'])->orderBy('lft')->asArray()->all();
    $array['leaves'] = $leaves;
    $array['cat'] = $categories;
    return $this->render('tests', [
        'model' => json_encode($array)
    ]);
  }


  public function actionGetLeaves()
  {
    $array = array();
    $leaves = Placement::find()->select('id')->leaves()->orderBy('lft')->asArray()->all();
    $categories = Placement::find()->select('id')->where(['!=', 'lvl', '0'])->orderBy('lft')->asArray()->all();
    $array['leaves'] = $leaves;
    $array['cat'] = $categories;
    return json_encode($array);
  }

}