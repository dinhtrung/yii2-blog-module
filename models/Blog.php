<?php

namespace vendor\dinhtrung\blog\models;

/**
 * This is the model class for table "tbl_blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $body
 * @property integer $status
 * @property integer $category_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property BlogTag $blogTag
 * @property Tag[] $tags
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'body', 'status', 'user_id', 'created_at'], 'required'],
            [['body'], 'string'],
            [['status', 'category_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('vendor/dinhtrung/blog/Blog', 'ID'),
            'title' => \Yii::t('vendor/dinhtrung/blog/Blog', 'Title'),
            'description' => \Yii::t('vendor/dinhtrung/blog/Blog', 'Description'),
            'body' => \Yii::t('vendor/dinhtrung/blog/Blog', 'Body'),
            'status' => \Yii::t('vendor/dinhtrung/blog/Blog', 'Status'),
            'category_id' => \Yii::t('vendor/dinhtrung/blog/Blog', 'Category ID'),
            'user_id' => \Yii::t('vendor/dinhtrung/blog/Blog', 'User ID'),
            'created_at' => \Yii::t('vendor/dinhtrung/blog/Blog', 'Created At'),
            'updated_at' => \Yii::t('vendor/dinhtrung/blog/Blog', 'Updated At'),
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
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('tbl_blog_tag', ['blog_id' => 'id']);
    }
}
