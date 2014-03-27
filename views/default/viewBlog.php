<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;

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
	    <h1><?= Html::encode($this->title) ?></h1>
	    <small>
	    	<time datetime="<?= \Yii::$app->formatter->asDatetime($model->created_at, 'Y-m-d H:i:s')?>"
	    			pubdate="<?= \Yii::$app->formatter->asDatetime($model->updated_at, 'Y-m-d H:i:s')?>">
	    			<?= \Yii::$app->formatter->asDatetime($model->updated_at)?>
	    	</time> by
	    	@AUTHOR.
	    </small>
	    <p class="lead"><?= $model->description; ?></p>
	</header>

	<div class="entry">
		<?= Markdown::convert($model->body); ?>
	</div>



    <footer>
        <?= Html::a(Yii::t('blog', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('blog', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('blog', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </footer>
</div>
