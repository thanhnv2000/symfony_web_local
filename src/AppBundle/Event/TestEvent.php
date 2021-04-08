<?php

declare(strict_types=1);

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 */
class TestEvent extends Event
{
    const NAME = "demo.event";

    /**
     */
    public function getDocument()
    {
        return '$this->document';
    }

 
}
