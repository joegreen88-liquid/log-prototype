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
     */
    public function make()
    {
        $logger = new Logger('liquid_audit_logger');

        $logger->pushHandler(new ElasticsearchHandler(
            App::getInstance()->service('Elasticsearch'),
            [
                'index' => 'audit-logs',
                'type'  => 'audit-log'
            ]
        ));

        return $logger;
    }
}