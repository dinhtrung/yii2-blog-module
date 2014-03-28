<?php

namespace vendor\dinhtrung\blog\controllers;

use Yii;
use vendor\dinhtrung\blog\models\Thread;
use vendor\dinhtrung\blog\models\ThreadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\VerbFilter;

/**
 * ThreadController implements the CRUD actions for Thread model.
 */
class ThreadController extends Controller
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
     * Lists all Thread models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThreadSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('indexThread', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Thread model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('viewThread', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Thread model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Thread;

        	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        		if ($model->parent == 0){
        			$model->saveNode();
        		} elseif ($model->parent){
        			$root = Thread::find($model->parent);
        			$model->appendTo($root);
        		}
        		return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('createThread', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Thread model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
   			$parent = Thread::find($model->parent);
   			if ($parent)
   				$model->moveAsLast($parent);
   			else
   				$model->moveAsRoot();
        	$model->saveNode();
        	return $this->redirect(['view', 'id' => $model->id]);
        } else {
	        $model->parent = ($parent = $model->parent()->one())?$parent->id:NULL;
            return $this->render('updateThread', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Thread model.
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
     * Finds the Thread model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Thread the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ($id !== null && ($model = Thread::find($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
