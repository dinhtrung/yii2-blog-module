<?php
use yii\helpers\Html;
use kartik\markdown\Markdown;
?>
<div class="blog-view">

    <h3><?= Html::encode($model->title) ?></h3>

    <p class="pull-right">
        <?= Html::a(Yii::t('blog', 'Update'), ['blog/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('blog', 'Delete'), ['blog/delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('blog', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <p><?= $model->description; ?></p>

    <?= Markdown::convert($model->body); ?>

</div>
<hr>