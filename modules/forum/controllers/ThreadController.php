<?php

namespace app\modules\forum\controllers;

use Yii;
use app\modules\forum\models\Thread;
use app\modules\forum\models\ThreadSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use app\modules\forum\repositories\ThreadRepositoryInterface;
use app\modules\forum\helpers\ThreadSorting;

/**
 * ThreadController implements the CRUD actions for Thread model.
 */
class ThreadController extends Controller
{
    protected $threadRepository;
    protected $threadSorting;

    public function __construct($id, $module, ThreadRepositoryInterface $threadRepository, ThreadSorting $threadSorting, $config = [])
    {
        $this->threadRepository = $threadRepository;
        $this->threadSorting = $threadSorting;
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
     * Lists all Thread models.
     * @return mixed
     * @param string $sort
     * @param string $direction
     */
    public function actionIndex($sort = null, $direction = null)
    {
        $query = $this->threadRepository->find();
        $query->with('repliesAggregation');
        if(!is_null($sort)) {
            $sorting = $this->threadSorting->getSortingOptions($sort, $direction);
            $query->orderBy($sorting->orders);
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
        $models = $query
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
            'sort' => $sort,
            'direction' => $direction
        ]);
    }

    /**
     * Displays a single Thread model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $model->trigger(Thread::EVENT_MODEL_VIEWED);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Thread model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Thread();
        $model->author = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
        if (($model = $this->threadRepository->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
