<?php

namespace dinhtrung\blog\controllers;

use Yii;
use dinhtrung\blog\models\Blog;
use dinhtrung\blog\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\VerbFilter;
use dinhtrung\blog\models\Tag;
use dinhtrung\blog\models\BlogTag;

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$tags = array_unique(preg_split( '/\s*,\s*/u',
        			preg_replace( '/\s+/u', ' ',
        					is_array($model->tagged) ? implode(',', $model->tagged) : $model->tagged
					), -1, PREG_SPLIT_NO_EMPTY ));
        	$rows = [];
        	foreach ($tags as $title){
        		$tag = Tag::find(['title' => $title]);
        		if ($tag === NULL) $tag = new Tag;
        		$tag->frequency++;
        		if (! $tag->save()) {
        			Yii::error("Cannot save tag " . $tag->title . json_encode($tag->getErrors()));
        			continue;
        		}
        		$rows[] = [$model->id, $tag->id];
        	}
        	if (! empty($rows)) $model->getDb()->createCommand()->batchInsert('{{%blog_tag}}', ['blog_id', 'tag_id'], $rows);

        	return $this->redirect(['view', 'id' => $model->id]);
        } else {
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
        foreach ($model->getTags()->all() as $item) {
        	$items[] = $item->title;
        }
        $model->tagged = implode(', ', $items);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$tags = array_unique(preg_split( '/\s*,\s*/u',
        			preg_replace( '/\s+/u', ' ',
        					is_array($model->tagged) ? implode(',', $model->tagged) : $model->tagged
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
        	if (! empty($rows)) $model->getDb()->createCommand()->batchInsert('{{%blog_tag}}', ['blog_id', 'tag_id'], $rows)->execute();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
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
        $model = $this->findModel($id);

        foreach (BlogTag::find()->where(['blog_id' => $model->id])->with('tag')->all() as $removedItem){
        	$removedItem->tag->frequency --;
        	$removedItem->tag->save();
        	$removedItem->delete();
        }
        $model->delete();

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