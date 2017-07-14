<?php

namespace app\modules\forum\events;

use yii\base\Component;
use yii\base\Event;

class ThreadViewedEvent extends Component implements ModelViewedEventInterface
{
    public function handle()
    {
        die("ppp");
    }
}
