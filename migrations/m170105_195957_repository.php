<?php

use yii\db\Migration;

class m170105_195957_repository extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%repository}}', [
            'id'          => $this->primaryKey(),
            'name'        => $this->string(100)->notNull()->unique(),
            'url_git'     => $this->string(200)->notNull()->unique(),
            'description' => $this->text(),
            'local_path'  => $this->string(200)->notNull(),
            'branch'      => $this->string(200)->notNull(),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
        ], $tableOptions);
        $this->createTable('{{%repository_history}}', [
            'id'         => $this->primaryKey(),
            'repo_id'    => $this->integer()->notNull(),
            'commit'     => $this->string(200)->notNull()->unique(),
            'author'     => $this->string(200),
            'modified'   => $this->text(),
            'added'      => $this->text(),
            'removed'    => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY ([[repo_id]]) REFERENCES {{%repository}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%repository_history}}');
        $this->dropTable('{{%repository}}');
    }
}
