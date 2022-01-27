<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Contact Person System',
    'description' => 'TYPO3 Contact Person System with Radius search and Search by Categories and Keywords.',
    'category' => 'plugin',
    'author' => 'Martin Hesse',
    'author_email' => 'info@creationx.de',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '1.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.9.99',
            'tt_address' => '5.3.0-6.0.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
