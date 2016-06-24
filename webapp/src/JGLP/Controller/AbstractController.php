<?php

namespace JGLP\Controller;

use JGLP\App;

abstract class AbstractController
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @return App
     */
    public function app()
    {
        if (! $this->app instanceof App) {
            $this->app = App::getInstance();
        }

        return $this->app;
    }

    /**
     * @return \Monolog\Logger
     */
    public function AuditLogger()
    {
        return $this->app()->service("AuditLogger");
    }
}