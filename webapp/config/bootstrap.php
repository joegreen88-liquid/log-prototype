<?php

date_default_timezone_set("Europe/London");

$this->errorHandler = function(\Exception $e) {
    ?>
    <h1>Exception</h1>
    <h2><?=$e->getMessage()?></h2>
    <pre><?=$e->getTraceAsString()?></pre>
    <?php
};