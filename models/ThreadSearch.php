<?php

namespace dinhtrung\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dinhtrung\blog\models\Thread;

/**
 * ThreadSearch represents the model behind the search form about `dinhtrung\blog\models\Thread`.
 */
class ThreadSearch extends Model
{
    public $id;
    public $title;
    public $body;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $blog_id;
    public $root;
    public $lft;
    public $rgt;
    public $level;

    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'blog_id', 'root', 'lft', 'rgt', 'level'], 'integer'],
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
            'root' => Yii::t('blog', 'Root'),
            'lft' => Yii::t('blog', 'Lft'),
            'rgt' => Yii::t('blog', 'Rgt'),
            'level' => Yii::t('blog', 'Level'),
        ];
    }

    public function search($params)
    {
        $query = Thread::find();
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
        $this->addCondition($query, 'root');
        $this->addCondition($query, 'lft');
        $this->addCondition($query, 'rgt');
        $this->addCondition($query, 'level');
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
