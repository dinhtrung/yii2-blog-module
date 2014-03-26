<?php

namespace vendor\dinhtrung\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use vendor\dinhtrung\blog\models\Category;

/**
 * CategorySearch represents the model behind the search form about `vendor\dinhtrung\blog\models\Category`.
 */
class CategorySearch extends Model
{
    public $id;
    public $root;
    public $lft;
    public $rgt;
    public $level;
    public $title;
    public $description;

    public function rules()
    {
        return [
            [['id', 'root', 'lft', 'rgt', 'level'], 'integer'],
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
            'root' => Yii::t('blog', 'Root'),
            'lft' => Yii::t('blog', 'Lft'),
            'rgt' => Yii::t('blog', 'Rgt'),
            'level' => Yii::t('blog', 'Level'),
            'title' => Yii::t('blog', 'Title'),
            'description' => Yii::t('blog', 'Description'),
        ];
    }

    public function search($params)
    {
        $query = Category::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'id');
        $this->addCondition($query, 'root');
        $this->addCondition($query, 'lft');
        $this->addCondition($query, 'rgt');
        $this->addCondition($query, 'level');
        $this->addCondition($query, 'title', true);
        $this->addCondition($query, 'description', true);
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
