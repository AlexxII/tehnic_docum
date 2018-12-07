<?php

use yii\db\Migration;

class m181130_082239_vks_sessions_tbl extends Migration
{
    const TABLE_NAME = '{{%vks_sessions_tbl}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'vks_date' => $this->date()->notNull(),

            'vks_teh_time_start' => $this->dateTime(),
            'vks_teh_time_end' => $this->dateTime(),
            'vks_duration_teh' => $this->integer(),
            'vks_work_time_start' => $this->dateTime(),
            'vks_work_time_end' => $this->dateTime(),
            'vks_duration_work' => $this->integer(),

            'vks_type' => $this->integer()->notNull(),
            'vks_place' => $this->integer(),

            'vks_subscriber_office' => $this->integer(),
            'vks_subscriber_name' => $this->string(255),

            'vks_order' => $this->integer(),
            'vks_order_number' => $this->string(255),
            'vks_order_date' => $this->date(),

            'vks_equipment' => $this->integer(),
            'vks_remarks' => $this->boolean()->defaultValue(0),                   // замечания

            'vks_employee' => $this->integer(),                                         // сотрудник спецсвязи, участв. в приеме

            'vks_subscriber_mur_office' => $this->integer(),
            'vks_subscriber_mur_name' => $this->string(255),

            'vks_employee_receive_msg' => $this->integer(),
            'vks_receive_msg_datetime' => $this->dateTime(),
            'vks_employee_send_msg' => $this->integer(),

            'vks_comments' => $this->text(),

            'vks_record_create' => $this->dateTime(),
            'vks_record_ipdate' => $this->dateTime(),

            'vks_upcoming_session' => $this->boolean()                                  // предстоящий сеанс ВКС
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME );
        return false;
    }
}
