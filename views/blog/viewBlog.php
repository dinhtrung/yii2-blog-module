<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var vendor\dinhtrung\blog\models\Blog $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="blog-view">

	<header>
	    <h1><small><?= \Yii::t('blog', 'Blog Post')?>:</small> <?= Html::encode($model->title) ?></h1>

	</header>
	    <p class="lead"><?= $model->description; ?></p>
	    <hr>

	    <?= kartik\markdown\Markdown::convert($model->body); ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'status', 'value' => $model->statusOptions($model->status)],
            'category_id',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
        ],
    ]) ?>

    <nav class="pull-right">
        <?= Html::a(Yii::t('blog', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('blog', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('blog', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </nav>
</article>
