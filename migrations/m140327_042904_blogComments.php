<?php

use yii\db\Schema;

class m140327_042904_blogComments extends \yii\db\Migration
{
    public function up()
    {
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    	}
    	$this->createTable('{{%comment}}', [
    			'id' => Schema::TYPE_PK,
    			'title' => Schema::TYPE_STRING,
    			'status' => Schema::TYPE_BOOLEAN,
    			'body' => Schema::TYPE_TEXT,
    			'blog_id' => Schema::TYPE_INTEGER,
    			'created_by' => Schema::TYPE_INTEGER,
    			'created_at' => Schema::TYPE_INTEGER,
    			'updated_by' => Schema::TYPE_INTEGER,
    			'updated_at' => Schema::TYPE_INTEGER,
    	], $tableOptions);
    	$this->addForeignKey('comment_blog', '{{%comment}}', 'blog_id', '{{%blog}}', 'id');
    	$this->createTable('{{%thread}}', [
    			'id' => Schema::TYPE_PK,
    			'title' => Schema::TYPE_STRING,
    			'status' => Schema::TYPE_BOOLEAN,
    			'body' => Schema::TYPE_TEXT,
    			'blog_id' => Schema::TYPE_INTEGER,
    			'created_by' => Schema::TYPE_INTEGER,
    			'created_at' => Schema::TYPE_INTEGER,
    			'updated_by' => Schema::TYPE_INTEGER,
    			'updated_at' => Schema::TYPE_INTEGER,
    			'root' => Schema::TYPE_INTEGER,
    			'level' => Schema::TYPE_INTEGER,
    			'lft' => Schema::TYPE_INTEGER,
    			'rgt' => Schema::TYPE_INTEGER,
    	], $tableOptions);
    	$this->addForeignKey('thread_blog', '{{%thread}}', 'blog_id', '{{%blog}}', 'id');
    }

    public function down()
    {
    	$this->dropTable('{{%thread}}');
    	$this->dropTable('{{%comment}}');
    }
}
