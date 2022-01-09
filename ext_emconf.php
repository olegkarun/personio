<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Personio',
    'description' => '',
    'category' => 'plugin',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
            'php' => '7.4.0-8.0.99'
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Pkd\\Personio\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Patrick Koschella',
    'author_email' => 'patrick@pkd.codes',
    'author_company' => 'PK Development',
    'version' => '0.1.3'
];
