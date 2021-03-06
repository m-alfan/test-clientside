<?php

use yii\db\Migration;

class m170106_161056_user extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id'       => $this->primaryKey(),
            'username' => $this->string(32)->notNull()->unique(),
            'token'    => $this->string()->notNull()->unique(),
            'expire'   => $this->integer(),
            'auth_key' => $this->string(32)->notNull(),
            'email'    => $this->string()->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
