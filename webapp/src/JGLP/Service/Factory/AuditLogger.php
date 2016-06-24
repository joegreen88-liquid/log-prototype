<?php

namespace JGLP\Service\Factory;

use Atrapalo\Monolog\Handler\ElasticsearchHandler;
use JGLP\App;
use JGLP\Service\ConfigurableTrait;
use Monolog\Logger;

/**
 * Class AuditLogger is a factory which produces a monolog logger instance for logging audit events.
 * 
 * This logger will log to elasticsearch (and soon mongodb).
 * 
 * @package JGLP\Service\Factory
 * @author Joe Green
 */
class AuditLogger implements FactoryInterface
{
    use ConfigurableTrait;

    /**
     * @return Logger
     *
     * @throws \Exception if not configured properly
     */
    public function make()
    {
        $logger = new Logger('liquid_audit_logger');
        $this->addElasticsearchHandler($logger);
        return $logger;
    }

    /**
     * @param Logger $logger
     *
     * @throws \Exception if not configured properly
     */
    protected function addElasticsearchHandler(Logger $logger)
    {
        if (!array_key_exists("Elasticsearch", $this->getConfig())) {
            throw new \Exception("No Elasticsearch config provided for AuditLogger service");
        }

        $config = (array) $this->getConfig("Elasticsearch");
        foreach (["index"] as $key) {
            if (!array_key_exists($key, $config)) {
                throw new \Exception("Missing \"$key\" from Elasticsearch config for AuditLogger service");
            }
        }

        $logger->pushHandler(new ElasticsearchHandler(
            App::getInstance()->service('Elasticsearch'),
            [
                'index' => $config["index"],
                'type'  => "user-".App::getInstance()->getUser(),
            ]
        ));
    }
}