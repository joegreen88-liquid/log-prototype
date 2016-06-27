<?php

namespace JGLP\Service\Factory;

use JGLP\Service\ServiceInterface;
use JGLP\Services;

interface FactoryInterface extends ServiceInterface
{
    /**
     * @param Services $services
     *   The service container is passed as a param so it can be used to fetch dependent services if needed.
     *
     * @return ServiceInterface
     */
    public function make(Services $services);
}