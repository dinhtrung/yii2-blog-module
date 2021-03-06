<?php

namespace dinhtrung\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dinhtrung\blog\models\Blog;

/**
 * BlogSearch represents the model behind the search form about `dinhtrung\blog\models\Blog`.
 */
class BlogSearch extends Model
{
    public $id;
    public $title;
    public $description;
    public $body;
    public $status;
    public $category_id;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return [
            [['id', 'status', 'category_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'body'], 'safe'],
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
            'description' => Yii::t('blog', 'Description'),
            'body' => Yii::t('blog', 'Body'),
            'status' => Yii::t('blog', 'Status'),
            'category_id' => Yii::t('blog', 'Category ID'),
            'created_by' => Yii::t('blog', 'Created By'),
            'updated_by' => Yii::t('blog', 'Updated By'),
            'created_at' => Yii::t('blog', 'Created At'),
            'updated_at' => Yii::t('blog', 'Updated At'),
        ];
    }

    public function search($params)
    {
        $query = Blog::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'description', true);
        $this->addCondition($query, 'body', true);
        $this->addCondition($query, 'status');
        $this->addCondition($query, 'category_id');
        $this->addCondition($query, 'created_by');
        $this->addCondition($query, 'updated_by');
        $this->addCondition($query, 'created_at');
        $this->addCondition($query, 'updated_at');
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
