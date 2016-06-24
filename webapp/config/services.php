<?php
return [
    'Elasticsearch' => [
        'factory' => '\\JGLP\\Service\\Factory\\Elasticsearch',
        'config' => [
            'hosts' => ['search']
        ]
    ],
    'AuditLogger' => [
        'factory' => '\\JGLP\\Service\\Factory\\AuditLogger',
        'config' => [
            'Elasticsearch' => [
                'service' => 'Elasticsearch',
                'index' => 'audit-log-'.date('Ymd')
            ]
        ]
    ]
];