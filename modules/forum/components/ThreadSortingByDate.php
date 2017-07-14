<?php

namespace app\modules\forum\components;

class ThreadSortingByDate implements ThreadSortingByAttributeInterface
{
    public function getTitle()
    {
        return \Yii::t('app', 'Date');
    }

    public function getAttributeName()
    {
        return 'creation_date';
    }
}
