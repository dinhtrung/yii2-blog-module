<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var vendor\dinhtrung\blog\models\ThreadSearch $searchModel
 */

$this->title = Yii::t('blog', 'Threads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thread-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('blog', 'Create {modelClass}', [
  'modelClass' => 'Thread',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'body:ntext',
            'created_at',
            'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'blog_id',
            // 'root',
            // 'lft',
            // 'rgt',
            // 'level',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
