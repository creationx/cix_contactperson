<?php
defined('TYPO3_MODE') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'CixContactperson',
        'Search',
        [
            \Creationx\CixContactperson\Controller\SearchController::class => 'form, details, search, perform'
        ],
        // non-cacheable actions
        [
            \Creationx\CixContactperson\Controller\SearchController::class => 'search, perform, details'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    search {
                        iconIdentifier = cix_contactperson-plugin-search
                        title = LLL:EXT:cix_contactperson/Resources/Private/Language/locallang_db.xlf:tx_cix_contactperson_search.name
                        description = LLL:EXT:cix_contactperson/Resources/Private/Language/locallang_db.xlf:tx_cix_contactperson_search.description
                        tt_content_defValues {
                            CType = list
                            list_type = cixcontactperson_search
                        }
                    }
                }
                show = *
            }
       }'
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'cix_contactperson-plugin-search',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:cix_contactperson/Resources/Public/Icons/user_plugin_suche.svg']
    );
})();
