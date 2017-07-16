<?php

namespace app\modules\auth\models;

use Yii;
use yii\base\Model;
use app\modules\auth\models\AppUser;

/**
 * SignupForm is the model behind the registration form.
 *
 * //@property User|null $user This property is read-only.
 *
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /*private $_user = false;*/


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $user = \Yii::$app->getModule('user');

        return [
            [['username', 'email'], 'trim'],
            ['email', 'unique', 'targetClass' => '\app\modules\auth\models\AppUser'],
            ['username', 'unique', 'targetClass' => '\app\modules\auth\models\AppUser'],
            [['username', 'email', 'password'], 'required'],
            [['email'], 'email'],
            ['password', 'string', 'min' => 8],
        ];
    }

    /**
     * Registers a new user account
     *
     * @return
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
        $user = Yii::createObject(AppUser::className());
        $user->setAttributes($this->attributes);
        if (!$user->register()) {
            return false;
        }

        return true;
    }
}
