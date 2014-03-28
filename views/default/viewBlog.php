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
	    	<time datetime="<?= \Yii::$app->formatter->asDatetime($model->created_at, 'Y-m-d H:i:s')?>"
	    			pubdate="<?= \Yii::$app->formatter->asDatetime($model->updated_at, 'Y-m-d H:i:s')?>">
	    			<?= \Yii::$app->formatter->asDatetime($model->updated_at)?>
	    	</time>
	    	@AUTHOR
	    <p class="lead"><?= $model->description; ?></p>
	</header>

	<div class="entry">
		<?= Markdown::convert($model->body); ?>
	</div>

    <footer>
    </footer>
</article>

<section class="comments">
	<?php foreach ($model->getComments()->all() as $item) echo $this->render('/comment/_itemComment', ['model' => $item])?>
	<?= $this->render('/comment/_formComment', ['model' => $comment, 'blog_id' => $model->id]); ?>
</section>

<section class="threads">
	<?php foreach ($model->getThreads()->all() as $item) echo $this->render('/thread/_itemThread', ['model' => $item])?>
	<?= $this->render('/thread/_formThread', ['model' => $thread, 'blog_id' => $model->id]); ?>
</section>
