<?php

namespace app\modules\forum\components;

class ThreadSortingByViews implements ThreadSortingByAttributeInterface
{
    public function getTitle()
    {
        return \Yii::t('app', 'Views');
    }

    public function getAttributeName()
    {
        return 'views';
    }
}
