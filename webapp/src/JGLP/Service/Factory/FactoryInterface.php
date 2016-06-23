<?php

namespace JGLP\Service\Factory;

use JGLP\Service\ServiceInterface;

interface FactoryInterface extends ServiceInterface
{
    /**
     * @return ServiceInterface
     */
    public function make();
}