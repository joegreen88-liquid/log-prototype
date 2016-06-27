<?php

namespace JGLP\Service;

use JGLP\ConfigurableInterface;
use JGLP\Services;

interface ServiceInterface extends ConfigurableInterface
{
    /**
     * Give the service object a reference to the service container.
     * 
     * @param Services $services
     *
     * @return static
     */
    public function setServiceContainer(Services $services);
}