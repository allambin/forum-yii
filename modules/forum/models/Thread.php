<?php

namespace app\modules\forum\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use app\modules\forum\components\DisallowUrlsValidator;

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
class Thread extends ActiveRecord
{
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['thread_id' => 'id']);
    }
}
