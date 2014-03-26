<?php

namespace vendor\dinhtrung\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use vendor\dinhtrung\blog\models\Tag;

/**
 * TagSearch represents the model behind the search form about `vendor\dinhtrung\blog\models\Tag`.
 */
class TagSearch extends Model
{
    public $id;
    public $title;
    public $description;
    public $frequency;

    public function rules()
    {
        return [
            [['id', 'frequency'], 'integer'],
            [['title', 'description'], 'safe'],
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
            'frequency' => Yii::t('blog', 'Frequency'),
        ];
    }

    public function search($params)
    {
        $query = Tag::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'description', true);
        $this->addCondition($query, 'frequency');
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
