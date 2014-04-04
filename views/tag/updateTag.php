<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dinhtrung\blog\models\Tag $model
 */

$this->title = Yii::t('blog', 'Update {modelClass}: ', [
  'modelClass' => 'Tag',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'Update');
?>
<div class="tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formTag', [
        'model' => $model,
    ]) ?>

</div>
