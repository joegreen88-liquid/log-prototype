<?php

namespace JGLP\Service\Factory;

use JGLP\ConfigurableInterface;
use JGLP\Services;

interface FactoryInterface extends ConfigurableInterface
{
    /**
     * @param Services $services
     *   The service container is passed as a param so it can be used to fetch dependent services if needed.
     *
     * @return mixed
     */
    public function make(Services $services);
}