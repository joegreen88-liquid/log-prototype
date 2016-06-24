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

    /**
     * @return \Elasticsearch\Client
     */
    public function Elasticsearch()
    {
        return $this->app()->service("Elasticsearch");
    }

    /**
     * @return string
     */
    public function activeUserBar()
    {
        ob_start();
        ?>
        <p>
            <em>Active User: <strong><?=htmlentities($this->app()->getUser())?></strong></em>
            <small><a href="/user/change">[change user]</a></small>
        </p>
        <hr>
        <?php
        return ob_get_clean();
    }
}