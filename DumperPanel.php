<?php

namespace cybernic\Dumper;

use yii\base\Event;
use yii\debug\Panel;
use yii\helpers\Html;

class DumperPanel extends Panel
{
    private $_dump = [];

    public function init()
    {
        parent::init();
        Event::on(Dumper::class, Dumper::EVENT_DUMPER, function (DumperEvent $event) {
            $this->_dump[] = $event->dumper->getDumpData();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Dumps';
    }

    /**
     * {@inheritdoc}
     */
    public function getSummary()
    {
        $url = $this->getUrl();
        $count = count($this->data);
        return "<div class=\"yii-debug-toolbar__block\"><a href=\"$url\">Dumps <span class=\"yii-debug-toolbar__label yii-debug-toolbar__label_info\">$count</span></a></div>";
    }

    /**
     * {@inheritdoc}
     */
    public function getDetail()
    {
        $result = '';

        /** @var array $data */
        foreach ($this->data as $data) {
            if (isset($data['backtrace'][2])) {
                $trace = $data['backtrace'][2];
                $result .= Html::tag('div', Html::tag('strong', $this->getTraceLine($trace)));
            }

            $result .= Html::tag('div', \yii\helpers\VarDumper::dumpAsString($data['var'], 10, true));
            $result .= '<br>';
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        return $this->_dump;
    }
}
