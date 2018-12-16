<?php

namespace app\modules\vks\models;

use Yii;
use yii\helpers\ArrayHelper;

class VksSessionsS extends VksSessions
{
    public function rules()
    {
        return [
            [[
                'vks_date', 'vks_type',
                'vks_employee_receive_msg',
                'vks_receive_msg_datetime',
                'vks_subscriber_office',
                'vks_order',
                'vks_place',
                'vks_equipment',
                'vks_employee',
                'vks_subscriber_mur_office',

                ], 'required'],
            ['vks_remarks', 'trim'],
            [['vks_date', 'vks_place', 'vks_teh_time_start', 'vks_teh_time_end',
                'vks_work_time_start', 'vks_work_time_end', 'vks_order_date',
                'vks_record_create', 'vks_record_update',
                'vks_subscriber_name', 'vks_order_number', 'vks_order_date',
                'vks_type_text', 'vks_place_text',
                'vks_order_text', 'vks_subscriber_office_text',
                'vks_subscriber_mur_office_text', 'vks_employee_send_msg_text'], 'safe'],
        ];
    }

}