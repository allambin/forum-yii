<?php

namespace app\modules\forum;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        if (\Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\forum\commands';
        }
        $this->setAliases([
            '@forum-assets' => __DIR__ . '/assets'
        ]);
        \Yii::$container->set('app\modules\forum\repositories\ThreadRepositoryInterface', 'app\modules\forum\repositories\ThreadRepository');
        $this->layout = 'main';
    }
}
