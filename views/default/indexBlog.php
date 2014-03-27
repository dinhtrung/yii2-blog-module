<?php

use yii\helpers\Html;
use yii\widgets\ListView;

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

    <?php // echo $this->render('_searchBlog', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('blog', 'Create {modelClass}', ['modelClass' => 'Blog',]), ['blog/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_itemBlog',
    ]) ?>

</div>
