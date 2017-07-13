<?php

namespace app\modules\forum\repositories;

use app\modules\forum\models\Thread;

class ThreadRepository implements ThreadRepositoryInterface
{
    public function find()
    {
        return Thread::find();
    }

    public function findOne($id)
    {
        return Thread::findOne($id);
    }
}
