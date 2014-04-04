<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var dinhtrung\blog\models\Thread $model
 */

$this->title = Yii::t('blog', 'Create {modelClass}', [
  'modelClass' => 'Thread',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Threads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thread-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formThread', [
        'model' => $model,
    ]) ?>

</div>
