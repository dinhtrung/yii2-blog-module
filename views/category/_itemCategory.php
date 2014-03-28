<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<div class="category-view">

    <h3><small><?= str_repeat('--',$model->level - 1) ?></small><?= Html::a($model->title, ['view', 'id' => $model->id]) ?></h3>
    <p class="lead"><?= $model->description; ?></p>

</div>
