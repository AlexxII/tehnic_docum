<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29.11.2018
 * Time: 16:59
 */

namespace app\modules\admin\models;
use yii\db\ActiveRecord;


class Testmodel extends ActiveRecord
{
//    public static function tableName()
//    {
//        return 'clsf_18353201_tbl';
//    }

    private static $tableName;

    public function __construct($tableName = null) {

        if ($tableName === null || $tableName === '') {
            return false;
        }
        self::$tableName = $tableName;
        parent::__construct();
    }

    public function rules()
    {
        return [
            [['Naimenovanie'], 'required'],
        ];
    }

}