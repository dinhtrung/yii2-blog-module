<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dinhtrung\blog\models\Comment $model
 */

$this->title = Yii::t('blog', 'Update {modelClass}: ', [
  'modelClass' => 'Comment',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'Update');
?>
<div class="comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formComment', [
        'model' => $model,
    ]) ?>

</div>
