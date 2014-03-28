<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use vendor\dinhtrung\blog\models\Thread;
use kartik\widgets\Select2;
use vendor\dinhtrung\blog\models\Blog;

/**
 * @var yii\web\View $this
 * @var vendor\dinhtrung\blog\models\Thread $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="thread-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title', [
				    			'options' => ['maxlength' => 255],
				    			'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-star"></i>']]
					]) ?>

    <?= $form->field($model, 'body')->widget(kartik\markdown\MarkdownEditor::className(), ['height' => 300 ]) ?>

    <?php if (! isset($blog_id)):?>

    <?= $form->field($model, 'blog_id')->widget(Select2::className(), [
				    'data' => ['' => '--- Select ---'] + Blog::options(),
				    'options' => [
				    	'placeholder' => 'Select a state ...',
				    	'multiple' => FALSE,
				    ],
				    'pluginOptions' => [
				        'allowClear' => true
				    ],
				]); ?>
	<?php endif; ?>

	<?php if (! isset($root)):?>
		<?= $form->field($model, 'parent')->dropDownList(['' => \Yii::t('app', '--- Select Parent ---')] + Thread::options())?>
	<?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
