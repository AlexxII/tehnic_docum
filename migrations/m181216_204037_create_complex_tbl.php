<?php

use yii\db\Migration;

class m181216_204037_create_complex_tbl extends Migration
{
    const TABLE_NAME = '{{%complex_tbl}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'id_eq' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'eq_title' => $this->string(255)->notNull(),
            'eq_manufact' => $this->string(255),
            'eq_model' => $this->string(255),
            'eq_serial' => $this->string(255),
            'eq_factdate' => $this->date(),
            'place_id' => $this->integer()->notNull(),
            'quantity' => $this->smallInteger()->notNull()->defaultValue(1),
            'valid' => $this->boolean()->defaultValue(1)
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
        return false;
    }


}
