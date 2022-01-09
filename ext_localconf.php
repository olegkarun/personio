<?php

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Pkd\Personio\Controller\PersonioController;

defined('TYPO3_MODE') || die();

(static function() {
  $typo3Information = GeneralUtility::makeInstance(Typo3Version::class);

  if ($typo3Information->getMajorVersion() === 10) {
    $icons = [
      'ext-personio-element-list' => 'ext-personio-element-list.svg',
      'ext-personio-element-show' => 'ext-personio-element-list.svg'
    ];    
    $iconRegistry = GeneralUtility::makeInstance(
      IconRegistry::class
    );
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(IconRegistry::class);
    foreach ($icons as $identifier => $path) {
        if (!$iconRegistry->isRegistered($identifier)) {
            $iconRegistry->registerIcon(
                $identifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                ['source' => 'EXT:personio/Resources/Public/Icons/' . $path]
            );
        }
    }
  }

  ExtensionUtility::configurePlugin(
    'Personio',
    'list',
    [
      PersonioController::class => 'list',
    ],
    // non-cacheable actions
    [
      PersonioController::class => '',
    ]
  );

  ExtensionUtility::configurePlugin(
    'Personio',
    'show',
    [
      PersonioController::class => 'show',
    ],
    // non-cacheable actions
    [
      PersonioController::class => '',
    ]
  );

  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    @import \'EXT:personio/Configuration/TsConfig/ContentElementWizard.tsconfig\'
  ');
})();