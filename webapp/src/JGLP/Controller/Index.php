<?php

namespace JGLP\Controller;

class Index extends AbstractController
{
    /**
     * Homepage
     */
    public function index()
    {
        echo $this->activeUserBar();
        ?>
        <h1>Log Prototype</h1>
        <hr>
        <ul>
            <li><a href="/event">Log an event (default)</a></li>
            <li><a href="/event/abc">Log an event (abc)</a></li>
            <li><a href="/event/123">Log an event (123)</a></li>
        </ul>
        <hr>
        <ul>
            <li><a href="/logs">View all logs</a></li>
            <li><a href="/logs/mine">View my logs</a></li>
            <li><a href="http://log-prototype:5601">Kibana dashboard</a></li>
        </ul>
        <hr>
        <ul>
            <li><a href="/check/elasticsearch">Check Elasticsearch</a></li>
            <li><a href="/check/phpinfo">Check phpinfo</a></li>
        </ul>
        <?php
    }

    /**
     * Log an event in the audit log
     */
    public function event()
    {
        echo $this->activeUserBar();
        $event = $this->app()->request->attributes->get("event", "default-event");
        ?>
        <h1>Logging Event: <code><?=htmlentities($event)?></code></h1>
        <p><?= $this->AuditLogger()->info($event) ? "Success" : "Failed" ?></p>
        <?php
    }

    /**
     * View the entire audit log
     */
    public function all_logs()
    {
        echo $this->activeUserBar();
        $es = $this->Elasticsearch();
        ?>
        <h1>All Logs</h1>
        <p>WIP</p>
        <pre><?=print_r($es->search(), true)?></pre>
        <?php
    }
    
    /**
     * View the active user's audit log
     */
    public function my_logs()
    {
        echo $this->activeUserBar();
        ?>
        <h1>My Logs</h1>
        <p>WIP</p>
        <?php
    }
}