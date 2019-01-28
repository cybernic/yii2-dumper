<?php

namespace cybernic\Dumper;

use yii\base\Component;

/**
 * Class Dumper
 *
 * @property $dumpData array

 * @package common\components
 */
class Dumper extends Component
{
    /**
     * @var mixed
     */
    private $_var;

    /**
     * @var array
     */
    private $_backtrace;

    const EVENT_DUMPER = 'eventDumper';

    /**
     * @param $var
     */
    public function dump($var)
    {
        $this->_var = $var;
        $this->_backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 3);

        $event = new DumperEvent();
        $event->dumper = $this;
        $this->trigger(self::EVENT_DUMPER, $event);
    }

    /**
     * @return array
     */
    public function getDumpData()
    {
        return [
            'var' => $this->_var,
            'backtrace' => $this->_backtrace,
        ];
    }

    /**
     * @param $var
     */
    public static function d($var)
    {
        $dumper = new self();
        $dumper->dump($var);
    }
}
