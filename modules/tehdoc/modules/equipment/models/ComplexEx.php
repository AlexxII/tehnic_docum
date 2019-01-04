<?php

namespace app\modules\tehdoc\modules\equipment\models;

use creocoder\nestedsets\NestedSetsBehavior;

class ComplexEx extends Complex
{

  public static function tableName()
  {
    return 'teh_complex_test_tbl';
  }

  public function behaviors() {
    return [
      'tree' => [
        'class' => NestedSetsBehavior::className(),
        'treeAttribute' => 'root',
        'leftAttribute' => 'lft',
        'rightAttribute' => 'rgt',
        'depthAttribute' => 'lvl',
      ],
      'htmlTree'=>[
        'class' => \wokster\treebehavior\NestedSetsTreeBehavior::className()
      ]
    ];
  }

  public function transactions()
  {
    return [
      self::SCENARIO_DEFAULT => self::OP_ALL,
    ];
  }

//  public static function find()
//  {
//    return new VksQuery(get_called_class());
//  }



}