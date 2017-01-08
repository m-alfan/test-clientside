<?php

use yii\db\Migration;

class m170108_061125_upload_file extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%upload_file}}', [
            'id'       => $this->primaryKey(),
            'name'     => $this->string(100),
            'path'     => $this->string(200),
            'thumb'    => $this->string(200),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%upload_file}}');
    }
}
