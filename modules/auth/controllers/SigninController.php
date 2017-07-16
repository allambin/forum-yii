<?php

namespace app\modules\auth\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\auth\models\SigninForm;

class SigninController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SigninForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
