<?php

namespace app\modules\vks\controllers\control;

use app\modules\vks\models\VksSubscribes;
use yii\web\Controller;

class VksSubscribesController extends Controller
{
    public $defaultAction = 'index';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSubscribes()
    {
        $id = VksSubscribes::find()->select('id, rgt, lft, root')->where(['=', 'lvl', 0])->all();
        if (!$id) {
            $data = array();
            $data = [['title' => 'База данных пуста', 'key' => -999]];
            return json_encode($data);
        }
        $roots = VksSubscribes::findOne($id)->tree();
        return json_encode($roots);
    }

    public function actionVksSubscribesCreate($parentTitle, $title)
    {
        $data = [];
        $category = VksSubscribes::findOne(['name' => $parentTitle]);
        $newSubcat = new VksSubscribes(['name' => $title]);
        $newSubcat->parent_id = $category->id;
        $newSubcat->appendTo($category);
        $data['acceptedTitle'] = $title;
        return json_encode($data);
    }

    public function actionCreateRoot($title)
    {
        \Yii::$app->db->schema->refresh();
        $newRoot = new VksSubscribes(['name' => $title]);
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
        $category = VksSubscribes::findOne(['id' => $id]);
        $category->name = $title;
        $category->save();
        return true;
    }

    public function actionMove($item, $action, $second)
    {
        $item_model = VksSubscribes::findOne($item);
        $second_model = VksSubscribes::findOne($second);
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
        $parent = VksSubscribes::findOne($second);
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
            $category = VksSubscribes::findOne(['id' => $id]);
            $category->delete();
        }
    }

    public function actionDeleteRoot()
    {
        if (!empty($_POST)) {
            $id = $_POST['id'];
            $root = VksSubscribes::findOne(['id' => $id]);
        }
        $root->deleteWithChildren();
    }

}