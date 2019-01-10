<?php

namespace app\modules\tehdoc\modules\equipment\models;

use app\modules\admin\models\Classifier;
use app\modules\admin\models\Placement;
use app\modules\tehdoc\models\Images;
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
class Tools extends \yii\db\ActiveRecord
{
  const PLACEMENT_TABLE = '{{%teh_placement_tbl}}';
  const CATEGORY_TABLE = '{{%teh_category_tbl}}';

  public static function tableName()
  {
    return 'teh_equipment_tbl';
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['id_eq', 'category_id', 'eq_title', 'place_id', 'quantity'], 'required'],
      [['id_eq', 'category_id', 'place_id', 'quantity'], 'integer'],
      [['eq_factdate', 'eq_comments'], 'safe'],
      [['eq_title', 'eq_manufact', 'eq_model', 'eq_serial'], 'string', 'max' => 250],
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
      'id_eq' => '',
      'category_id' => 'Категория оборудования:',
      'eq_title' => 'Наименование:',
      'eq_manufact' => 'Производитель:',
      'eq_model' => 'Модель:',
      'eq_serial' => 's/n:',
      'eq_factdate' => 'Дата производства:',
      'place_id' => 'Место нахождения:',
      'quantity' => 'Количество:',
      'eq_comments' => 'Примечание:'
//        'valid' => 'Valid',
    ];
  }

  public function fields()
  {
    return [

    ];
  }

  public function getPhotos()
  {
    return $this->hasMany(Images::class, ['eq_id' => 'id_eq']);
  }


  public function getCategory()
  {
    return $this->hasOne(Category::class, ['ref' => 'category_id']);
  }

  public function getCategoryTitle()
  {
    // TODO: Возможно необходимо сделать переменную $depth настраиваемой
    $depth = 1; // сколько уровней
    if ($this->category) {
      $full = $this->category;
      $parentCount = $full->parents()->count();
      $parent = $full->parents($parentCount - $depth)->all();
      $fullname = '';
      foreach ($parent as $p) {
        $fullname .= $p->name . ' ->';
      }
      return $fullname . ' ' . $this->category->name;
    } else {
      return '-';
    }
  }

  public function getPlacement()
  {
    return $this->hasOne(Placement::class, ['ref' => 'place_id']);
  }

  public function getPlacementTitle()
  {
    // TODO: Возможно необходимо сделать переменную $depth настраиваемой
    $depth = 1; // сколько уровней
    if ($this->placement) {
      $full = $this->placement;
      $parentCount = $full->parents()->count();
      $parent = $full->parents($parentCount - $depth)->all();
      $fullname = '';
      foreach ($parent as $p) {
        $fullname .= $p->name . ' ->';
      }
      return $fullname . ' ' . $this->placement->name;
    } else {
      return '-';
    }
  }


  // Доступ к свойствам объекта
  public function getId()
  {
    return $this->id;
  }

  public function getClsf($table)
  {
    return $this->hasMany(Classifier::class, ['eq_id' => 'id_eq']);
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

  public function getQuantity()
  {
    $ar = array();
    $length = 50;
    for ($i = 1; $i <= $length; $i++) {
      $ar[$i] = $i;
    }
    return $ar;
  }
//======================================================================================================================

  // DropDown lists
  public function getToolPlacesList()
  {
    $sql = "SELECT C1.ref, C1.name, C2.name as gr from " . self::PLACEMENT_TABLE . " C1 LEFT JOIN "
      . self::PLACEMENT_TABLE . " C2 on C1.parent_id = C2.ref WHERE C1.lvl > 1 ORDER BY C1.lft";
    return ArrayHelper::map($this->findBySql($sql)->asArray()->all(), 'ref', 'name', 'gr');
  }

  public function getToolCategoryList()
  {
    $sql = "SELECT C1.ref, C1.name, C2.name as gr from " . self::CATEGORY_TABLE . " C1 LEFT JOIN "
      . self::CATEGORY_TABLE . " C2 on C1.parent_id = C2.ref WHERE C1.lvl > 1 AND C1.root = 1 ORDER BY C1.lft";
    return ArrayHelper::map($this->findBySql($sql)->asArray()->all(), 'ref', 'name', 'gr');
  }

//======================================================================================================================
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
