<?php

namespace JGLP\Controller;

use JGLP\App;

class Check extends AbstractController
{
    public function elasticsearch()
    {
        /**
         * @var \Elasticsearch\Client $es
         */
        $es = $this->app()->service('Elasticsearch');

        // 1. PUT a document
        $response = $es->index([
            'index' => 'meta',
            'type'  => 'health-check',
            'id'    => 'health-check-put',
            'body'  => [
                'foo' => 'bar',
            ],
        ]);
        echo "<h2>PUT a health check document</h2>";
        echo "<pre>".print_r($response, true)."</pre>";
        echo "<hr>";

        // 2. fetch a document
        $response = $es->get([
            'index' => 'meta',
            'type'  => 'health-check',
            'id'    => 'health-check-put',
        ]);
        echo "<h2>GET the health check document</h2>";
        echo "<pre>".print_r($response, true)."</pre>";
        echo "<hr>";
    }
}