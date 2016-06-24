<?php
return [
    'Elasticsearch' => [
        'factory' => '\\JGLP\\Service\\Factory\\Elasticsearch',
        'config' => [
            'hosts' => ['search']
        ]
    ],
    'AuditLogger' => [
        'factory' => '\\JGLP\\Service\\Factory\\AuditLogger'
    ]
];