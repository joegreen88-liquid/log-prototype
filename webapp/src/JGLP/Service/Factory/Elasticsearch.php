<?php

namespace JGLP\Service\Factory;

use JGLP\Service\ConfigurableTrait;

class Elasticsearch implements FactoryInterface
{
    use ConfigurableTrait;

    /**
     * @return \Elasticsearch\Client
     */
    public function make()
    {
        return \Elasticsearch\ClientBuilder::create()->fromConfig($this->getConfig());
    }
}