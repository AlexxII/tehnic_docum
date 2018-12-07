<?php

namespace app\modules\vks\controllers\control;

use app\modules\vks\models\VksPlaces;
use yii\web\Controller;

class VksPlaceController extends Controller
{
    public $defaultAction = 'index';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPlaces()
    {
        $id = VksPlaces::find()->select('id, rgt, lft, root')->where(['=', 'lvl', 0])->all();
        if (!$id) {
            $data = array();
            $data = [['title' => 'База данных пуста', 'key' => -999]];
            return json_encode($data);
        }
        $roots = VksPlaces::findOne($id)->tree();
        return json_encode($roots);
    }

    public function actionVksPlaceCreate($parentTitle, $title)
    {
        $data = [];
        $category = VksPlaces::findOne(['name' => $parentTitle]);
        $newSubcat = new VksPlaces(['name' => $title]);
        $newSubcat->parent_id = $category->id;
        $newSubcat->appendTo($category);
        $data['acceptedTitle'] = $title;
        return json_encode($data);
    }

    public function actionCreateRoot($title)
    {
        \Yii::$app->db->schema->refresh();
        $newRoot = new VksPlaces(['name' => $title]);
        $result = $newRoot->makeRoot();
        if ($result){
            $data['acceptedTitle'] = $title;
            return json_encode($data);
        } else {
            return var_dump('0');
        }
    }

    public function actionUpdate($id, $title)
    {
        $category = VksPlaces::findOne(['id' => $id]);
        $category->name = $title;
        $category->save();
        return true;
    }

    public function actionMove($item, $action, $second)
    {
        $item_model = VksPlaces::findOne($item);
        $second_model = VksPlaces::findOne($second);
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
        $parent = VksPlaces::findOne($second);
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
            $category = VksPlaces::findOne(['id' => $id]);
            $category->delete();
        }
    }

    public function actionDeleteRoot()
    {
        if (!empty($_POST)) {
            $id = $_POST['id'];
            $root = VksPlaces::findOne(['id' => $id]);
        }
        $root->deleteWithChildren();
    }

}