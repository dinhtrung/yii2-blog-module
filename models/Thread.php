<?php

namespace vendor\dinhtrung\blog\models;

/**
 * This is the model class for table "tbl_thread".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $blog_id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 */
class Thread extends \yii\db\ActiveRecord
{
	public $parent;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%thread}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['blog_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            // Additional attributes
            [['parent'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('vendor/dinhtrung/blog/Thread', 'ID'),
            'title' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Title'),
            'body' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Body'),
            'created_at' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Created At'),
            'created_by' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Created By'),
            'updated_at' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Updated At'),
            'updated_by' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Updated By'),
            'blog_id' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Blog ID'),
            'root' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Root'),
            'lft' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Lft'),
            'rgt' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Rgt'),
            'level' => \Yii::t('vendor/dinhtrung/blog/Thread', 'Level'),
        ];
    }

    /**
     * Add extra behaviors for model
     */
    public function behaviors(){
    	return [
	    	['class' => 'yii\behaviors\TimestampBehavior'],
	    	['class' => 'yii\behaviors\BlameableBehavior'],
	    	[ 'class' => NestedSet::className (), 'hasManyRoots' => TRUE ],
    	];
    }

    /**
     * Override createQuery
     * @param unknown $config
     */
    public static function createQuery($config = array())
    {
    	$config['modelClass'] = get_called_class();
    	return (new ThreadQuery($config))->orderBy('root ASC, lft ASC');
    }
    /**
     * Return an array of available items, suitable for dropDownList()
     * @param number $root  ID of root nodes to retrieve
     * @param string $level  The level of tree to retrieve
     * @return array $res  An associate array with key - value
     */
    public static function options($root = 0, $level = NULL){
    	$res = [];
    	if ($root instanceof self){
    		$res[$root->id] = str_repeat('-', $root->level) . ' ' . $root->title;
    		if ($level){
    			foreach ($root->children()->all() as $childRoot){
    				$res += self::options($childRoot, $level - 1);
    			}
    		} elseif (is_null($level)){
    			foreach ($root->children()->all() as $childRoot){
    				$res += self::options($childRoot, NULL);
    			}
    		}
    	} elseif (is_scalar($root)){
    		if ($root == 0){
    			foreach (self::find()->roots()->all() as $rootItem){
    				if ($level){
    					$res += self::options($rootItem, $level - 1);
    				} elseif (is_null($level)){
    					$res += self::options($rootItem, NULL);
    				}
    			}
    		} else {
    			$root = self::find($root);
    			if ($root) 	$res += self::options($root, $level);
    		}
    	}
    	return $res;
    }
}

/**
 * Extends the ActiveQuery Class
 */
class ThreadQuery extends ActiveQuery {
	public function behaviors() {
		return [
		[ 'class' => NestedSetQuery::className(), ],
		];
	}
}
