<?php

namespace vendor\dinhtrung\blog\models;

use yii\helpers\ArrayHelper;
use app\models\User;
/**
 * This is the model class for table "tbl_blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $body
 * @property integer $status
 * @property integer $category_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property BlogTag $blogTag
 * @property Tag[] $tags
 */
class Blog extends \yii\db\ActiveRecord
{
	const STATUS_PENDING = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_ARCHIVED = 2;

	public $tagged;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'body', 'status'], 'required'],
            [['body'], 'string'],
            [['status', 'category_id'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            // Extra properties
            [['tagged'], 'string'],
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
            'description' => \Yii::t('blog', 'Description'),
            'body' => \Yii::t('blog', 'Body'),
            'status' => \Yii::t('blog', 'Status'),
            'category_id' => \Yii::t('blog', 'Category ID'),
            'created_at' => \Yii::t('blog', 'Created At'),
            'updated_at' => \Yii::t('blog', 'Updated At'),
            'created_by' => \Yii::t('blog', 'Created By'),
            'updated_by' => \Yii::t('blog', 'Updated By'),
            'tagNames' => \Yii::t('blog', 'Tags'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTag()
    {
        return $this->hasOne(BlogTag::className(), ['blog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('{{%blog_tag}}', ['blog_id' => 'id']);
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
     * Aliasing function
     */
    public static function statusOptions($i = NULL) {
    	$options = [
			self::STATUS_PENDING		=>	\Yii::t('blog', 'Pending'),
			self::STATUS_ACTIVE			=>	\Yii::t('blog', 'Active'),
			self::STATUS_ARCHIVED 	=>	\Yii::t('blog', 'Archived'),
    	];
    	if (is_null($i)) return $options;
    	elseif (array_key_exists($i, $options)) return $options[$i];
    	else return $i;
    }

    /**
     * Return the option list suitable for dropDownList
     */
    public static function options($q = NULL){
    	return ArrayHelper::map(self::find()->where($q)->all(), 'id', 'title');
    }
}
