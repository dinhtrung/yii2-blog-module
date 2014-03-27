<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use vendor\dinhtrung\blog\models\Blog;
use vendor\dinhtrung\blog\models\Comment;

/**
 * @var yii\web\View $this
 * @var vendor\dinhtrung\blog\models\Comment $model
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
		    <?= $form->field($model, 'blog_id')->widget(Select2::className(), [
		        'data' => ["" => "--- Select ---"] + Blog::options(['status' => Blog::STATUS_ACTIVE]),
		    ])?>
	    </div>
    </div>
    <div class="row">
	    <div class="col-xs-3">
		    <?= $form->field($model, 'status')->dropDownList(Comment::statusOptions()) ?>
	    </div>
    </div>


   	<?= $form->field($model, 'body')->widget(kartik\markdown\MarkdownEditor::className(), ['height' => 300 ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
