<?php

namespace app\modules\forum\models;

use Yii;

/**
 * This is the model class for table "user_thread_views".
 *
 * @property integer $id
 * @property string $creation_date
 * @property integer $author
 * @property integer $thread_id
 *
 * @property Threads $thread
 */
class UserThreadView extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_thread_views';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThread()
    {
        return $this->hasOne(Threads::className(), ['id' => 'thread_id']);
    }
}
