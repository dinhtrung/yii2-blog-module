<?php

namespace vendor\dinhtrung\blog\models;

/**
 * This is the model class for table "tbl_tag".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $frequency
 *
 * @property BlogTag $blogTag
 * @property Blog[] $blogs
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'frequency'], 'required'],
            [['description'], 'string'],
            [['frequency'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('vendor/dinhtrung/blog/Tag', 'ID'),
            'title' => \Yii::t('vendor/dinhtrung/blog/Tag', 'Title'),
            'description' => \Yii::t('vendor/dinhtrung/blog/Tag', 'Description'),
            'frequency' => \Yii::t('vendor/dinhtrung/blog/Tag', 'Frequency'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogTag()
    {
        return $this->hasOne(BlogTag::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogs()
    {
        return $this->hasMany(Blog::className(), ['id' => 'blog_id'])->viaTable('tbl_blog_tag', ['tag_id' => 'id']);
    }
}
