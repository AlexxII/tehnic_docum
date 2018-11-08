<?php

namespace app\modules\admin\models;

use Yii;

class PlacementTbl extends \kartik\tree\models\Tree
{
  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'placement_tbl';
  }
}