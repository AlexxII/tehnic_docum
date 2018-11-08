<?php

use yii\db\Migration;

/**
 * Handles the creation of table `classifier`.
 */
class m180925_181735_create_classifier_table extends Migration
{
  const TABLE_NAME = '{{%classifier_tbl}}';

  /**
   * @inheritdoc
   */
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
        'name' => $this->string(60)->notNull(),
        'icon' => $this->string(255),
        'icon_type' => $this->smallInteger(1)->notNull()->defaultValue(1),
        'active' => $this->boolean()->notNull()->defaultValue(true),
        'selected' => $this->boolean()->notNull()->defaultValue(false),
        'disabled' => $this->boolean()->notNull()->defaultValue(false),
        'readonly' => $this->boolean()->notNull()->defaultValue(false),
        'visible' => $this->boolean()->notNull()->defaultValue(true),
        'collapsed' => $this->boolean()->notNull()->defaultValue(false),
        'movable_u' => $this->boolean()->notNull()->defaultValue(true),
        'movable_d' => $this->boolean()->notNull()->defaultValue(true),
        'movable_l' => $this->boolean()->notNull()->defaultValue(true),
        'movable_r' => $this->boolean()->notNull()->defaultValue(true),
        'removable' => $this->boolean()->notNull()->defaultValue(true),
        'removable_all' => $this->boolean()->notNull()->defaultValue(false)
    ], $tableOptions);
    $this->createIndex('tree_NK1', self::TABLE_NAME, 'root');
    $this->createIndex('tree_NK2', self::TABLE_NAME, 'lft');
    $this->createIndex('tree_NK3', self::TABLE_NAME, 'rgt');
    $this->createIndex('tree_NK4', self::TABLE_NAME, 'lvl');
    $this->createIndex('tree_NK5', self::TABLE_NAME, 'active');
  }

  /**
   * @inheritdoc
   */
  public function down()
  {
    $this->dropTable(self::TABLE_NAME);
  }

}
