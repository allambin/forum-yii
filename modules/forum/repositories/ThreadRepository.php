<?php

namespace app\modules\forum\repositories;

use app\modules\forum\models\Thread;

class ThreadRepository implements ThreadRepositoryInterface, UserThreadViewRepositoryInterface
{
    public function find()
    {
        return Thread::find();
    }

    public function findOne($id)
    {
        return Thread::findOne($id);
    }

    public function saveViewByUser($id, $userId)
    {
        $userThreadView = \app\modules\forum\models\UserThreadView::find()
                                                                    ->where([
                                                                        'author' => $userId,
                                                                        'thread_id' => $id
                                                                    ])
                                                                    ->one();
        if($userThreadView) {
            $userThreadView->delete();
        }
        $userThreadView = new \app\modules\forum\models\UserThreadView();
        $userThreadView->author = $userId;
        $userThreadView->thread_id = $id;
        $userThreadView->save();
    }

    public function findViewByUser($id, $userId)
    {
        return \app\modules\forum\models\UserThreadView::find()
                                                        ->where([
                                                            'author' => $userId,
                                                            'thread_id' => $id
                                                        ])
                                                        ->one();
    }

    public function incrementView($id)
    {
        $thread = Thread::findOne($id);
        $thread->updateCounters(['views' => 1]);
    }
}
