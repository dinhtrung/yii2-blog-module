<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var vendor\dinhtrung\blog\models\Thread $model
 */

$this->title = Yii::t('blog', 'Update {modelClass}: ', [
  'modelClass' => 'Thread',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Threads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'Update');
?>
<div class="thread-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formThread', [
        'model' => $model,
    ]) ?>

</div>
