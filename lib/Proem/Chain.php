<?php

namespace Proem;

require_once 'Chain/ChainAbstract.php';

class Chain extends Chain\ChainAbstract
{
    public function run() {
        $event = $this->getInitialEvent();
        $event->run($this);
    }
}