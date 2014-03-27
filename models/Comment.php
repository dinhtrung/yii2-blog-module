<?php

namespace vendor\dinhtrung\blog\models;

/**
 * This is the model class for table "tbl_comment".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property boolean $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $blog_id
 *
 * @property Blog $blog
 */
class Comment extends \yii\db\ActiveRecord
{
	const STATUS_PENDING = 0;
	const STATUS_APPROVED = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'blog_id'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('blog', 'ID'),
            'title' => \Yii::t('blog', 'Title'),
            'body' => \Yii::t('blog', 'Body'),
            'created_at' => \Yii::t('blog', 'Created At'),
            'created_by' => \Yii::t('blog', 'Created By'),
            'updated_at' => \Yii::t('blog', 'Updated At'),
            'updated_by' => \Yii::t('blog', 'Updated By'),
            'blog_id' => \Yii::t('blog', 'Blog ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }

    /**
     * Add extra behaviors for model
     */
    public function behaviors(){
    	return [
    	['class' => 'yii\behaviors\TimestampBehavior'],
    	['class' => 'yii\behaviors\BlameableBehavior'],
    	];
    }

    /**
     * Return a list of status option
     */
    public static function statusOptions($i = NULL) {
        	$options = [
    			self::STATUS_PENDING		=>	\Yii::t('app', 'Pending'),
    			self::STATUS_APPROVED	=>	\Yii::t('app', 'Approved'),
        	];
        	if (is_null($i)) return $options;
        	elseif (array_key_exists($i, $options)) return $options[$i];
        	else return $i;
        }
}
