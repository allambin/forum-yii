<?php

namespace app\modules\forum\repositories;

interface PostRepositoryInterface
{
    /**
    * Returns an Active Query
    */
    public function find();

    /**
    * Finds one record
    */
    public function findOne($id);
}
