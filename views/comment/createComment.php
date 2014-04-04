<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dinhtrung\blog\models\Comment $model
 */

$this->title = Yii::t('blog', 'Create {modelClass}', [
  'modelClass' => 'Comment',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formComment', [
        'model' => $model,
    ]) ?>

</div>
