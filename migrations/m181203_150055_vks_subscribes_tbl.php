<?php

use yii\db\Migration;

class m181203_150055_vks_subscribes_tbl extends Migration
{
    const TABLE_NAME = '{{%vks_subscribes_tbl}}';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->bigPrimaryKey(),
            'root' => $this->integer(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'lvl' => $this->smallInteger(5)->notNull(),
            'name' => $this->string(120)->notNull(),
            'parent_id' => $this->integer(),
            'srnames' => $this->text()
        ], $tableOptions);

        $sql = 'INSERT INTO' . self::TABLE_NAME . '(id, root, lft, rgt, lvl, name, parent_id) 
                VALUES (1, 1, 1, 2, 0, "Старшие абоненты", 1), (2, 2, 3, 4, 0, "Абоненты в субъекте", 2)';
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
        return false;
    }
}
