<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use vendor\dinhtrung\blog\models\Category;
use vendor\dinhtrung\blog\models\Blog;

/**
 * @var yii\web\View $this
 * @var vendor\dinhtrung\blog\models\Blog $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
	    <div class="col-xs-9">
		    <?= $form->field($model, 'title', [
						    			'options' => ['maxlength' => 255],
						    			'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-star"></i>']]
							]) ?>

		    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
		    <?= $form->field($model, 'tagNames') ?>
	    </div>
	    <div class="col-xs-3">
		    <?= $form->field($model, 'status')->dropDownList(Blog::statusOptions()) ?>
		    <?= $form->field($model, 'category_id')->widget(Select2::className(), [
						    'data' => ['' => '--- Select ---'] + Category::options(),
						    'options' => [
						    	'multiple' => FALSE,
						    ],
						    'pluginOptions' => [
						        'allowClear' => true
						    ],
						]); ?>
	    </div>
    </div>


    <?= $form->field($model, 'body')->widget(kartik\markdown\MarkdownEditor::className(), ['height' => 300 ]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
