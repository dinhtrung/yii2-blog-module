<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dinhtrung\blog\models\Tag $model
 */

$this->title = Yii::t('blog', 'Create {modelClass}', [
  'modelClass' => 'Tag',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formTag', [
        'model' => $model,
    ]) ?>

</div>
