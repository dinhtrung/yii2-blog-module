<?php

namespace dinhtrung\blog\models;

/**
 * This is the model class for table "tbl_blog_tag".
 *
 * @property integer $blog_id
 * @property integer $tag_id
 *
 * @property Tag $tag
 * @property Blog $blog
 */
class BlogTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_blog_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'tag_id'], 'required'],
            [['blog_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'blog_id' => \Yii::t('vendor/dinhtrung/blog/BlogTag', 'Blog ID'),
            'tag_id' => \Yii::t('vendor/dinhtrung/blog/BlogTag', 'Tag ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }
}
