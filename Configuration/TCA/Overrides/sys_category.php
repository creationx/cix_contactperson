<?php
defined('TYPO3_MODE') or die();

$ll = 'LLL:EXT:cix_contactperson/Resources/Private/Language/locallang_db.xlf:';
$newSysCategoryColumns = [
    'cix_keywords' => [
        'exclude' => true,
        'label' => $ll . 'category.cix_keywords',
        'config' => [
            'type' => 'input',
        ],
    ],
    'cix_zips' => [
        'exclude' => true,
        'label' => $ll . 'category.cix_zips',
        'config' => [
            'type' => 'text',
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_category', $newSysCategoryColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    '--div--;' . $ll . 'tabs.cixcategory, cix_keywords, cix_zips',
    '',
    'after:endtime'
);