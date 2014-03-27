<?php
use yii\helpers\Html;
use kartik\markdown\Markdown;
?>
<article class="blog-item">
	<header>
	    <h3><?= Html::a($model->title, ['view', 'id' => $model->id]); ?></h3>
	    <small>
	    	<time datetime="<?= \Yii::$app->formatter->asDatetime($model->created_at, 'Y-m-d H:i:s')?>"
	    			pubdate="<?= \Yii::$app->formatter->asDatetime($model->updated_at, 'Y-m-d H:i:s')?>">
	    			<?= \Yii::$app->formatter->asDatetime($model->updated_at)?>
	    	</time> by
	    	@AUTHOR.
	    </small>
	</header>
    <p class="lead"><?= $model->description; ?></p>
    <footer>
        <?= Html::a(Yii::t('blog', 'Update'), ['blog/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('blog', 'Delete'), ['blog/delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('blog', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </footer>
</article>
<hr>