<?php

namespace dinhtrung\blog\controllers;

use Yii;
use dinhtrung\blog\models\Blog;
use dinhtrung\blog\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\VerbFilter;
use dinhtrung\blog\models\Comment;
use dinhtrung\blog\models\Thread;

/**
 * DefaultController implements the CRUD actions for Blog model.
 */
class DefaultController extends Controller
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
    	$comment  = new Comment();
    	if ($comment->load(Yii::$app->request->post())) {
    		$comment->blog_id = $id;
    		$comment->status = Comment::STATUS_PENDING;
    		$comment->save();
    		return $this->redirect('');
    	}
        return $this->render('viewBlog', [
            'model' => $this->findModel($id),
        	'comment' => $comment,
        ]);
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
