<?php

namespace cybernic\Dumper;

use yii\base\Event;

/**
 * DumperEvent represents the event parameter used for an Dumper events.
 */
class DumperEvent extends Event
{
    /**
     * @var Dumper
     */
    public $dumper;
}
