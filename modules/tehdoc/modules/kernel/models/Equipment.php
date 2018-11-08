<?php

namespace app\modules\tehdoc\modules\kernel\models;

use app\modules\admin\models\Placement;
use app\modules\tehdoc\models\Images;
use app\modules\admin\models\Subcategory;
use Yii;
use app\modules\admin\models\Category;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "equipment_tbl".
 *
 * @property int $id
 * @property int $id_eq
 * @property int $category_id
 * @property string $eq_title
 * @property string $eq_manufact
 * @property string $eq_model
 * @property string $eq_serial
 * @property string $eq_factdate
 * @property int $place_id
 * @property int $quantity
 * @property int $valid Оборудование по умолчанию будет отображаться
 */
class Equipment extends \yii\db\ActiveRecord
{
  /**
   * @inheritdoc
   */


  public static function tableName()
  {
    return 'equipment_tbl';
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['id_eq', 'category_id', 'eq_title', 'place_id'], 'required'],
        [['id_eq', 'category_id', 'place_id', 'quantity'], 'integer'],
        [['eq_factdate'], 'safe'],
        [['eq_title', 'eq_manufact', 'eq_model', 'eq_serial'], 'string', 'max' => 250],
//        [['valid'], 'string', 'max' => 1],
        [['id_eq'], 'unique'],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
        'id' => 'ID',
        'id_eq' => 'Id Eq',
        'category_id' => 'Категория оборудования:',
        'eq_title' => 'Наименование:',
        'eq_manufact' => 'Производитель:',
        'eq_model' => 'Модель:',
        'eq_serial' => 'Серийный номер:',
        'eq_factdate' => 'Дата производства:',
        'place_id' => 'Место нахождения:',
        'quantity' => 'Количество:',
//        'valid' => 'Valid',
    ];
  }


  public function getPhotos()
  {
    return $this->hasMany(Images::class, ['eq_id' => 'id_eq']);
  }

  public function getPlacement()
  {
    return $this->hasOne(Placement::class, ['id' => 'place_id']);
  }

  // Доступ к свойствам
  public function getId()
  {
    return $this->id;
  }

  public function getSubcategoryTitle()
  {
    if ($this->subcategory){
      return $this->subcategory->name;
    } else {
      return '-';
    }
  }

  public function getCategoryTitle()
  {
    if ($title = $this->subcategory){
      $subCat = Category::findOne(['name' => $title]);
      $parent = $subCat->parents(1)->one();
      return $parent->name;
    } else {
      return '-';
    }
  }

  public function getSubcategory()
  {
    return $this->hasOne(Category::class, ['id' => 'category_id']);
  }

  public function getEqTitle()
  {
    return $this->eq_title;
  }

  public function getEqManufact()
  {
    return $this->eq_manufact;
  }

  public function getEqModel()
  {
    return $this->eq_model;
  }

  public function getEqSerial()
  {
    return $this->eq_serial;
  }

  public function getFactDate()
  {
    if ($this->eq_factdate) {
      return strftime("%b %G", strtotime($this->eq_factdate)) . ' год';
    } else {
      return '-';
    }
  }

  public function getPlace()
  {
    if ($this->placement){
      $full = $this->placement;
      $parentCount = $full->parents()->count();
      $parent = $full->parents($parentCount - 2)->all();
      $fullname = '';
      foreach ($parent as $p) {
        $fullname .= $p->name . ' ->';
      }
      return $fullname . ' ' . $this->placement->name;
    } else {
      return '-';
    }
  }

  public function getQuantity()
  {
    $ar = array();
    $length = 50;
    for($i = 1; $i <= $length; $i++){
      $ar[$i] = $i;
    }
    return $ar;
  }


  public function getClsf($table)
  {

    return $this->hasMany(Images::class, ['eq_id' => 'id_eq']);
  }

  /*  public function beforeSave($insert)
    {
      if (parent::beforeSave($insert)) {
        if ($this->eq_factdate) {
          $this->eq_factdate = strftime("%Y-%m-%d", strtotime($this->eq_factdate));
        }
        return parent::beforeSave($insert);
      } else {
        return false;
      }
    }*/

}
