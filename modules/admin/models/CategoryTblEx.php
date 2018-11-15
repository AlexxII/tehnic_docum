<?php

namespace app\modules\admin\models;

use kartik\tree\models\TreeTrait;
use Yii;

class CategoryTblEx extends \kartik\tree\models\Tree
{
    // Важно!!!! Класс переопределяет метод для отображения только категории - родители

    public function isDisabled()
    {
        $res = $this->parse('disabled');
        if ($res == 1) {
            return 0;
        } else {
            return 1;
        }
    }

    public static function tableName()
    {
        return 'category_tbl';
    }

    public static function findOnlyParents()
    {

    }

}