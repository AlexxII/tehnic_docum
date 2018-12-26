<?php

namespace app\modules\tehdoc\modules\equipment\models;

use Yii;
use yii\helpers\ArrayHelper;

class Complex extends \yii\db\ActiveRecord
{

  const PLACEMENT_TABLE = '{{%teh_placement_tbl}}';
  const CATEGORY_TABLE = '{{%teh_category_tbl}}';

  public static function tableName()
  {
    return 'teh_complex_tbl';
  }

  public function rules()
  {
    return [
      [['category_id', 'complex_title', 'place_id'], 'required'],
      [['category_id', 'place_id', 'quantity', 'valid'], 'integer'],
      [['complex_factdate', 'complex_comments'], 'safe'],
      [['complex_title', 'complex_serial', 'complex_manufact'], 'string', 'max' => 255],
    ];
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'category_id' => 'Категория:',
      'complex_title' => 'Наименование:',
      'complex_manufact' => 'Производитель:',
      'complex_model' => 'Модель:',
      'complex_serial' => 's/n:',
      'complex_factdate' => 'Дата производства:',
      'place_id' => 'Место нахождения:',
      'quantity' => 'Количество:',
      'valid' => 'Valid',
      'complex_comments' => 'Примечание:'
    ];
  }

  public function getTools()
  {
    return $this->hasOne(Tools::class, ['id' => 'complex_id']);
  }


  public function getToolPlacesList()
  {
    $sql = "SELECT C1.id, C1.name, C2.name as gr from " . self::PLACEMENT_TABLE . " C1 LEFT JOIN "
      . self::PLACEMENT_TABLE . " C2 on C1.parent_id = C2.id WHERE C1.lvl > 1 ORDER BY C1.lft";
    return ArrayHelper::map($this->findBySql($sql)->asArray()->all(), 'id', 'name', 'gr');
  }

  public function getToolCategoryList()
  {
    $sql = "SELECT C1.id, C1.name, C2.name as gr from " . self::CATEGORY_TABLE . " C1 LEFT JOIN "
      . self::CATEGORY_TABLE . " C2 on C1.parent_id = C2.id WHERE C1.lvl > 1 ORDER BY C1.lft";
    return ArrayHelper::map($this->findBySql($sql)->asArray()->all(), 'id', 'name', 'gr');
  }

}
