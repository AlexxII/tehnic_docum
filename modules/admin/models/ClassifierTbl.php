<?php

namespace app\modules\admin\models;

use Yii;

class ClassifierTbl extends \kartik\tree\models\Tree
{
  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'teh_classifier_tbl';
  }
}