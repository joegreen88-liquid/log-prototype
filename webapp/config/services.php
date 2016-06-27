<?php
return [
    'AuditLogger' => [
        'factory' => '\\JGLP\\Service\\Factory\\AuditLogger',
        'config' => [
            'Elasticsearch' => [
                'service' => 'Elasticsearch',
                'index' => 'audit-log-'.date('Ymd')
            ]
        ]
    ],
    'Elasticsearch' => [
        'factory' => '\\JGLP\\Service\\Factory\\Elasticsearch',
        'config' => [
            'hosts' => ['search']
        ]
    ],
    'User' => [
        'class' => '\\JGLP\\Service\\User'
    ],
];