<?php

namespace app\modules\forum\repositories;

use app\modules\forum\models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function find()
    {
        return Post::find();
    }

    public function findOne($id)
    {
        return Post::findOne($id);
    }
}
