<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dinhtrung\blog\models\Category $model
 */

$this->title = Yii::t('blog', 'Create {modelClass}', [
  'modelClass' => 'Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formCategory', [
        'model' => $model,
    ]) ?>

</div>
