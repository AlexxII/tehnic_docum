<?php

use yii\db\Migration;

/**
 * Class m181031_200539_create_image_tbl
 */
class m181031_200539_create_image_tbl extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('image_tbl', [
            'id' => $this->primaryKey(),
            'eq_id' => $this->integer()->notNull(),
            'image_path' => $this->string(255)->notNull()->unique(),
            'valid' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);
    }
    public function down()
    {
        $this->dropTable('user');
    }

}
