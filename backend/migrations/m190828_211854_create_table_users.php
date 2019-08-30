<?php

use yii\db\Migration;

/**
 * Class m190828_211854_create_table_users
 */
class m190828_211854_create_table_users extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'ID' => $this->primaryKey()->notNull(),
            'ACTIVE' => $this->char(1)->notNull(),
            'NAME' => $this->string(255)->notNull(),
            'LAST_NAME' => $this->string(255)->notNull(),
            'EMAIL' => $this->string(255)->notNull(),
            'XML_ID' => $this->string(255)->notNull(),
            'PERSONAL_GENDER' => $this->char(255)->notNull(),
            'PERSONAL_BIRTHDAY' => $this->date(),
            'WORK_POSITION' => $this->string(255),
            'Region' => $this->string(255),
            'City' => $this->string(255),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
