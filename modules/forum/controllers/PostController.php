<?php

namespace app\modules\forum\controllers;

use Yii;
use app\modules\forum\models\Post;
use app\modules\forum\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\forum\repositories\PostRepositoryInterface;
use app\modules\forum\repositories\ThreadRepositoryInterface;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    protected $threadRepository;
    protected $postRepository;

    public function __construct($id, $module, PostRepositoryInterface $postRepository, ThreadRepositoryInterface $threadRepository, $config = [])
    {
        $this->threadRepository = $threadRepository;
        $this->postRepository = $postRepository;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($thread_id)
    {
        $thread = $this->findThreadModel($thread_id);
        $model = new Post();
        $model->thread_id = $thread->id;
        $model->author = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['thread/view', 'id' => $thread->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->postRepository->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Thread model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Thread the related model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findThreadModel($id)
    {
        if (($model = $this->threadRepository->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
