<?php

namespace vendor\dinhtrung\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use vendor\dinhtrung\blog\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `vendor\dinhtrung\blog\models\Comment`.
 */
class CommentSearch extends Model
{
    public $id;
    public $title;
    public $body;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $blog_id;

    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'blog_id'], 'integer'],
            [['title', 'body'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'title' => Yii::t('blog', 'Title'),
            'body' => Yii::t('blog', 'Body'),
            'created_at' => Yii::t('blog', 'Created At'),
            'created_by' => Yii::t('blog', 'Created By'),
            'updated_at' => Yii::t('blog', 'Updated At'),
            'updated_by' => Yii::t('blog', 'Updated By'),
            'blog_id' => Yii::t('blog', 'Blog ID'),
        ];
    }

    public function search($params)
    {
        $query = Comment::find()->with('user')->with('blog');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'body', true);
        $this->addCondition($query, 'created_at');
        $this->addCondition($query, 'created_by');
        $this->addCondition($query, 'updated_at');
        $this->addCondition($query, 'updated_by');
        $this->addCondition($query, 'blog_id');
        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        $value = $this->$modelAttribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
