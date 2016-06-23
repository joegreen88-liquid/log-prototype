<?php

// Route requests for static assets if php built-in webserver is being used
if ("cli-server" === php_sapi_name()) {
    if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
        return false; // return asset requests to the web server
    }
}

echo "Welcome to the web app!";