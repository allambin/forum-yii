<?php

namespace app\modules\forum\components;

use yii\validators\Validator;

class DisallowUrlsValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (preg_match('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', $model->$attribute)) {
            $this->addError($model, $attribute, \Yii::t('app', 'The content cannot contain a url'));
        }
    }
}
