<?php

namespace JGLP\Controller;

class Index extends AbstractController
{
    public function index()
    {
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
            <li><a href="/check-elasticsearch">Check Elasticsearch</a></li>
        </ul>
        <?php
    }

    /**
     * Log an event in the audit log
     */
    public function event()
    {
        $event = $this->app()->request->attributes->get("event", "default-event");
        ?>
        <h1>Logging Event: <code><?=htmlentities($event)?></code></h1>
        <p><?= $this->AuditLogger()->info($event) ? "Success" : "Failed" ?></p>
        <?php
    }
}