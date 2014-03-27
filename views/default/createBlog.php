<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var vendor\dinhtrung\blog\models\Blog $model
 */

$this->title = Yii::t('blog', 'Create {modelClass}', [
  'modelClass' => 'Blog',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formBlog', [
        'model' => $model,
    ]) ?>

</div>
