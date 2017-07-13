<?php

namespace app\modules\forum\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;

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
            [['content'], 'validateNoUrl'],
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

     public function validateNoUrl($attribute, $params, $validator)
     {
        if (preg_match('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', $this->$attribute)) {
            $this->addError($attribute, Yii::t('app', 'The content cannot contain a url'));
        }
     }

}
