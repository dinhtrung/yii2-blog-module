<?php

namespace vendor\dinhtrung\blog\controllers;

use Yii;
use vendor\dinhtrung\blog\models\Blog;
use vendor\dinhtrung\blog\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\VerbFilter;
use vendor\dinhtrung\blog\models\Tag;
use vendor\dinhtrung\blog\models\BlogTag;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('indexBlog', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('viewBlog', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog;
        if (is_array($model->tags)) $model->tags = implode(', ', $model->tags);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$tags = array_unique(preg_split( '/\s*,\s*/u',
        			preg_replace( '/\s+/u', ' ',
        					is_array($this->tags) ? implode(',', $this->tags) : $this->tags
					), -1, PREG_SPLIT_NO_EMPTY ));
        	$rows = [];
        	foreach ($tags as $title){
        		$tag = Tag::find(['title' => $title]);
        		if ($tag === NULL) $tag = new Tag;
        		$tag->frequency++;
        		if (! $tag->save()) {
        			Yii::error("Cannot save tag " . $tag->title);
        			continue;
        		}
        		$rows[] = [$model->id, $tag->id];
        	}
        	if (! empty($rows)) $model->getDb()->createCommand()->batchInsert('{{%blog_tag}}', ['blog_id', 'tag_id'], $rows);

        	return $this->redirect(['view', 'id' => $model->id]);
        } else {
        	$model->tags = implode(',', $model->tags);
            return $this->render('createBlog', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $items = [];
        foreach ($model->tags as $item) {
        	$items[] = $item->title;
        }
        $model->tagNames = implode(', ', $items);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$tags = array_unique(preg_split( '/\s*,\s*/u',
        			preg_replace( '/\s+/u', ' ',
        					is_array($model->tagNames) ? implode(',', $model->tagNames) : $model->tagNames
        			), -1, PREG_SPLIT_NO_EMPTY ));
        	$removed = array_diff($items, $tags);
        	foreach (Tag::find()->where(['in', 'title', $removed])->all() as $removedItem){
        		BlogTag::deleteAll(['blog_id' => $model->id, 'tag_id' => $removedItem->id]);
        		$removedItem->frequency --;
        		$removedItem->save();
        	}

        	$added = array_diff($tags, $items);
        	$rows = [];
        	foreach ($added as $title){
        		$tag = Tag::find(['title' => $title]);
        		if (! $tag) {
        			$tag = new Tag;
        			$tag->title = $title;
        		}
        		$tag->frequency++;
        		if (! $tag->save()) {
        			Yii::error("Cannot save tag " . $tag->title . json_encode($tag->getErrors()));
        			continue;
        		}
        		$rows[] = [$model->id, $tag->id];
        	}
        	// @TODO: Must know for sure if we need to remove something...
        	if (! empty($rows)) $model->getDb()->createCommand()->batchInsert('{{%blog_tag}}', ['blog_id', 'tag_id'], $rows)->execute();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
//         	$model->populateRelation('tags', $model->getTags()->all());
//         	if ($model->isRelationPopulated('tags')){

//         	}
            return $this->render('updateBlog', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ($id !== null && ($model = Blog::find($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
