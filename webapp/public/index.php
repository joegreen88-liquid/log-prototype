<?php

// Route requests for static assets if php built-in webserver is being used
if ("cli-server" === php_sapi_name()) {
    if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
        return false; // return asset requests to the web server
    }
}

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/../paths.php';

if ("cli" === php_sapi_name()) {

    date_default_timezone_set("Europe/London");
    $app = new \Symfony\Component\Console\Application("log-prototype");
    $app->add(new \JGLP\Command\SeedLogs);
    $app->run();

} else {
    // Run the web app
    \JGLP\App::getInstance()->bootstrap()->run();
}

