<?php

namespace vendor\dinhtrung\blog\controllers;

use Yii;
use vendor\dinhtrung\blog\models\Category;
use vendor\dinhtrung\blog\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('indexCategory', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('viewCategory', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	if ($model->parent == 0){
        		$model->saveNode();
        	} elseif ($model->parent){
        		$root = Category::find($model->parent);
        		$model->appendTo($root);
        	}
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('createCategory', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parent = $model->parent();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	if ($model->parent == 0){
        		$model->moveAsRoot();
        	} elseif ($model->parent != $parent){
        		$root = Category::find($model->parent);
        		$model->moveAsLast($root);
        	}
        	$model->saveNode();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('updateCategory', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUp($id)
    {
        $model = $this->findModel($id);

        $parent = $model->parent()->one();
        if ($parent) \Yii::trace("Found previous node: " . $parent->id . ' --- ' . $parent->title);

        $prev = $model->prev()->one();
        if ($prev)  \Yii::trace("Found previous node: " . $prev->id . ' --- ' . $prev->title);

        if ($prev) $model->moveBefore($prev);
        elseif ($parent){
        	if ($parent->isRoot()) {
        		$model->moveAsRoot();
        	} else {
        		$model->moveBefore($parent);
        	}
        }
        return $this->redirect(['index']);
    }
    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDown($id)
    {
        $model = $this->findModel($id);

        $parent = $model->parent()->one();
        if ($parent) $parent = $parent->next()->one();
        if ($parent) \Yii::trace("Found next parent node: " . $parent->id . ' --- ' . $parent->title);

        $next = $model->next()->one();
        if ($next)  \Yii::trace("Found previous node: " . $next->id . ' --- ' . $next->title);

        if ($next) $model->moveAfter($next);
        elseif ($parent){
        	if ($parent->isRoot()) {
        		$model->moveAsRoot();
        	} else {
        		$model->moveAfter($parent);
        	}
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteNode();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ($id !== null && ($model = Category::find($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
