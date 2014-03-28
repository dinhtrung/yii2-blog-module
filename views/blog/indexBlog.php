<?php

use yii\helpers\Html;
use yii\grid\GridView;
use vendor\dinhtrung\blog\models\Blog;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var vendor\dinhtrung\blog\models\BlogSearch $searchModel
 */

$this->title = Yii::t('blog', 'Blogs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('blog', 'Create {modelClass}', [
  'modelClass' => 'Blog',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'title', 'value' => function($data){ return \yii\helpers\Html::a($data->title, ['view', 'id' => $data->id]); }, 'format' => 'html'],
            'description',
//             'body:ntext',
            ['attribute' => 'status', 'value' => function($data) { return Blog::statusOptions($data->status); }],
            // 'category_id',
            // 'user_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
