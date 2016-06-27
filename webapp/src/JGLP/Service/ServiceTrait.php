<?php

namespace JGLP\Service;

use JGLP\Services;

trait ServiceTrait
{
    /**
     * @var Services
     */
    public $services;

    /**
     * @inheritDoc
     */
    public function setServiceContainer(Services $services)
    {
        $this->services = $services;
        return $this;
    }
}