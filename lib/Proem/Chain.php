<?php

namespace Proem;

require_once 'Chain/AbstractChain.php';

class Chain extends Chain\AbstractChain
{
    public function run() {
        $event = $this->getInitialEvent();
        $event->run($this);
    }
}