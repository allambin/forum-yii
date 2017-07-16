<?php

namespace app\modules\forum\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use app\modules\forum\components\DisallowUrlsValidator;
use app\modules\forum\events\ModelViewedEventInterface;
use app\modules\forum\repositories\ThreadRepository;

/**
 * This is the model class for table "threads".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $creation_date
 * @property integer $author
 * @property integer $views
 */
class Thread extends ActiveRecord implements ModelViewedEventInterface
{
    public function init()
    {
        $this->on(ModelViewedEventInterface::EVENT_MODEL_VIEWED, [$this, 'handleViews'], new ThreadRepository);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'threads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string', 'max' => 100],
            ['content', DisallowUrlsValidator::className()],
            [['creation_date'], 'safe'],
            [['author', 'views'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'creation_date' => 'Creation Date',
            'author' => 'Author',
            'views' => 'Views',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creation_date'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'rating' => [
                'class' => \chiliec\vote\behaviors\RatingBehavior::className(),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['thread_id' => 'id']);
    }

    public function getRepliesCount()
    {
        if($this->isNewRecord) {
            return null;
        }

        return empty($this->repliesAggregation) ? 0 : $this->repliesAggregation[0]['counted'];
    }

    public function getRepliesAggregation()
    {
        return $this->getPosts()
                    ->select(['thread_id', 'counted' => 'count(*)'])
                    ->groupBy('thread_id')
                    ->asArray(true);
    }

    public function handleViews($event)
    {
        $threadRepository = $event->data;
        $userId = isset(\Yii::$app->user->id) ? \Yii::$app->user->id : 0;
        $view = $threadRepository->findViewByUser($this->id, $userId);
        if(!isset($view) || strtotime($view->creation_date) < strtotime('-1 day')) {
            $threadRepository->saveViewByUser($this->id, $userId);
            $threadRepository->incrementView($this->id);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\modules\auth\models\AppUser::className(), ['id' => 'author']);
    }
}
