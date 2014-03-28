<?php

use yii\helpers\Html;
use kartik\markdown\Markdown;
?>
<article class="comment-view">

    <h4><?= Html::encode($model->title) ?></h4>
	<?= Markdown::convert($model->body); ?>
</article>
