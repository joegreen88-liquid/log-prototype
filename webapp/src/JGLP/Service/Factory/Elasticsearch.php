<?php

namespace JGLP\Service\Factory;

use Elasticsearch\ClientBuilder;
use JGLP\ConfigurableTrait;
use JGLP\Services;

class Elasticsearch implements FactoryInterface
{
    use ConfigurableTrait;

    /**
     * @inheritdoc
     *
     * @return \Elasticsearch\Client
     */
    public function make(Services $services)
    {
        return ClientBuilder::create()->fromConfig($this->getConfig());
    }
}