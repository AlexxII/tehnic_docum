<?php

namespace app\modules\admin\models;

use Yii;

class CategoryTbl extends \kartik\tree\models\Tree
{
  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'category_tbl';
  }

}