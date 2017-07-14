<?php

namespace app\modules\forum\repositories;

interface UserThreadViewRepositoryInterface
{
    /**
     * Saves the date of the viewing
     */
    public function saveViewByUser($id, $userId);

    /**
     * Returns the view of a user for a thread
     */
    public function findViewByUser($id, $userId);

    /**
     * Increments the views property
     */
    public function incrementView($id);
}
