<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use dinhtrung\blog\models\Blog;
use dinhtrung\blog\models\Comment;

/**
 * @var yii\web\View $this
 * @var dinhtrung\blog\models\Comment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
	    <div class="col-xs-9">
		    <?= $form->field($model, 'title', [
						'options' => ['maxlength' => 255],
						'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-star"></i>']]
			]) ?>
			<?php if (! isset($blog_id)):?>
		    <?= $form->field($model, 'blog_id')->widget(Select2::className(), [
		        'data' => ["" => "--- Select ---"] + Blog::options(['status' => Blog::STATUS_ACTIVE]),
		    ])?>
		    <?php endif; ?>
	    </div>
    </div>
    <?php if (! isset($blog_id)):?>
    <div class="row">
	    <div class="col-xs-3">
		    <?= $form->field($model, 'status')->dropDownList(Comment::statusOptions()) ?>
	    </div>
    </div>
	<?php endif; ?>


   	<?= $form->field($model, 'body')->widget(kartik\markdown\MarkdownEditor::className(), ['height' => 300 ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
