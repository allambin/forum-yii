<?php

namespace app\modules\auth\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\auth\models\SignupForm;

class SignupController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = \Yii::createObject(SignupForm::className());
        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            return $this->redirect(['/auth/signin']);
        }
        return $this->render('index', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}
