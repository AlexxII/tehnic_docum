<?php

namespace app\modules\vks\models;

use Yii;

/**
 * This is the model class for table "vks_sessions_tbl".
 *
 * @property int $id
 * @property string $vks_date
 * @property string $vks_teh_time_start
 * @property string $vks_teh_time_end
 * @property int $vks_duration_teh
 * @property string $vks_work_time_start
 * @property string $vks_work_time_end
 * @property int $vks_duration_work
 * @property int $vks_type
 * @property int $vks_place
 * @property string $vks_subscriber_office
 * @property string $vks_subscriber_name
 * @property int $vks_order
 * @property string $vks_order_number
 * @property string $vks_order_date
 * @property int $vks_equipment
 * @property int $vks_remarks
 * @property int $vks_employee
 * @property int $vks_employee_receive_msg
 * @property string $vks_receive_msg_datetime
 * @property int $vks_employee_send_msg
 * @property string $vks_comments
 * @property string $vks_record_create
 * @property string $vks_record_ipdate
 */
class VksSessions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vks_sessions_tbl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vks_date', 'vks_type', 'vks_employee_receive_msg', 'vks_receive_msg_datetime', 'vks_employee_send_msg'], 'required'],
            [['vks_date', 'vks_teh_time_start', 'vks_teh_time_end', 'vks_work_time_start', 'vks_work_time_end', 'vks_order_date', 'vks_receive_msg_datetime', 'vks_record_create', 'vks_record_ipdate'], 'safe'],
            [['vks_duration_teh', 'vks_duration_work', 'vks_type', 'vks_place', 'vks_order', 'vks_equipment', 'vks_remarks', 'vks_employee', 'vks_employee_receive_msg', 'vks_employee_send_msg'], 'integer'],
            [['vks_comments'], 'string'],
            [['vks_subscriber_office', 'vks_subscriber_name', 'vks_order_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vks_date' => 'Дата проведения ВКС:',
            'vks_teh_time_start' => 'Время начала техн.:',
            'vks_teh_time_end' => 'Время окончания техн:',
            'vks_duration_teh' => 'Vks Duration Teh',
            'vks_work_time_start' => 'Время начала рабоч.:',
            'vks_work_time_end' => 'Время окончания рабоч:',
            'vks_duration_work' => 'Vks Duration Work',
            'vks_type' => 'Тип ВКС:',
            'vks_place' => 'Место проведения ВКС:',
            'vks_subscriber_office' => 'Абонент:',
            'vks_subscriber_name' => 'Фамилия:',
            'vks_order' => 'Распоряжение:',
            'vks_order_number' => '№ док-та:',
            'vks_order_date' => 'Дата док-та:',
            'vks_equipment' => 'Оборудование ВКС:',
            'vks_remarks' => 'Замечания',
            'vks_employee' => 'Сотрудник СпецСвязи:',
            'vks_subscriber_mur_office' => 'Присутствовали:',
            'vks_subscriber_mur_name' => 'Фамилия:',
            'vks_employee_receive_msg' => 'Принявший сообщение:',
            'vks_receive_msg_datetime' => 'Дата сообщения:',
            'vks_employee_send_msg' => 'Передавший сообщение:',
            'vks_comments' => 'Примечание:',
            'vks_record_create' => 'Vks Record Create',
            'vks_record_ipdate' => 'Vks Record Ipdate',
        ];
    }
}