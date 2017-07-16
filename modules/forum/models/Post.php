<?php

namespace app\modules\forum\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use app\modules\forum\components\DisallowUrlsValidator;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $content
 * @property string $creation_date
 * @property integer $author
 * @property integer $thread_id
 *
 * @property Threads $thread
 */
class Post extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['creation_date'], 'safe'],
            [['content'], 'string', 'max' => 100],
            ['content', DisallowUrlsValidator::className()],
            [['author', 'thread_id'], 'required'],
            [['author', 'thread_id'], 'integer'],
            [['thread_id'], 'exist', 'skipOnError' => true, 'targetClass' => Thread::className(), 'targetAttribute' => ['thread_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'creation_date' => Yii::t('app', 'Creation Date'),
            'author' => Yii::t('app', 'Author'),
            'thread_id' => Yii::t('app', 'Thread ID'),
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
}
