<?php

use yii\db\Schema;

class m140326_181847_blog extends \yii\db\Migration
{
    public function up()
    {
    	$tableOptions = null;
    	if ($this->db->driverName === 'mysql') {
    		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
    	}
    	$this->createTable('{{%category}}', [
    			'id' => Schema::TYPE_PK,
    			'root' => Schema::TYPE_INTEGER,
    			'lft' => Schema::TYPE_INTEGER,
    			'rgt' => Schema::TYPE_INTEGER,
    			'level' => Schema::TYPE_INTEGER,
    			'title' => Schema::TYPE_STRING,
    			'description' => Schema::TYPE_TEXT,
    	], $tableOptions);
    	$this->createTable('{{%tag}}', [
    			'id' => Schema::TYPE_PK,
    			'title' => Schema::TYPE_STRING,
    			'description' => Schema::TYPE_TEXT,
    	], $tableOptions);
    	$this->createTable('{{%blog}}', [
    			'id' => Schema::TYPE_PK,
    			'title' => Schema::TYPE_STRING,
    			'description' => Schema::TYPE_TEXT,
    			'body' => Schema::TYPE_TEXT,
    			'status' => Schema::TYPE_BOOLEAN,
    			'category_id' => Schema::TYPE_INTEGER,
    			'user_id' => Schema::TYPE_INTEGER,
    			'created_at' => Schema::TYPE_TIMESTAMP,
    			'updated_at' => Schema::TYPE_TIMESTAMP,
    	], $tableOptions);

    }

    public function down()
    {
    	$this->dropTable('{{%blog_tag}}');
    	$this->dropTable('{{%tag}}');
    	$this->dropTable('{{%blog}}');
    	$this->dropTable('{{%category}}');
    }
}
