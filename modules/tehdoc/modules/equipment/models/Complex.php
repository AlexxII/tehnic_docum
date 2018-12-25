<?php

namespace app\modules\tehdoc\modules\equipment\models;
use Yii;

class Complex extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'teh_complex_tbl';
    }

    public function rules()
    {
        return [
            [['category_id', 'complex_title', 'place_id'], 'required'],
            [['category_id', 'place_id', 'quantity', 'valid'], 'integer'],
            [['complex_factdate'], 'safe'],
            [['complex_title', 'complex_serial', 'complex_manufact'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория:',
            'complex_title' => 'Наименование:',
            'complex_serial' => 's/n:',
            'complex_manufact' => 'Производитель:',
            'complex_factdate' => 'Дата производства:',
            'place_id' => 'Место нахождения:',
            'quantity' => 'Количество',
            'valid' => 'Valid',
        ];
    }
}
