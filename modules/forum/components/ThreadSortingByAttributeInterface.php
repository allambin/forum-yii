<?php

namespace app\modules\forum\components;

interface ThreadSortingByAttributeInterface
{
    /**
     * Returns the title
     */
    public function getTitle();

    /**
     * Returns the model attribute name 
     */
    public function getAttributeName();
}
