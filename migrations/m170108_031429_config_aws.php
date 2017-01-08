<?php

use yii\db\Migration;

class m170108_031429_config_aws extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%config_aws}}', [
            'id'         => $this->primaryKey(),
            'region'     => $this->string(100)->notNull()->unique(),
            'key'        => $this->string(200)->notNull()->unique(),
            'secret'     => $this->string(200)->notNull()->unique(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%config_aws}}');
    }
}
