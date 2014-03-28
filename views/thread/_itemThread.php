<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;
?>
<div class="row">
	<article class="thread-view col-xs-<?= 12 - $model->level; ?> col-xs-push-<?= $model->level; ?>">
	    <h4><?= Html::encode($model->title) ?></h4>
		<?= Markdown::convert($model->body); ?>
		<?= ($parent = $model->parent()->one())?$parent->title:NULL ?>
	</article>
</div>
