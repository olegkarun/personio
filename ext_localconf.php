<?php
defined('TYPO3_MODE') || die();

(static function() {
  $typo3Information = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);

  if ($typo3Information->getMajorVersion() === 10) {
    $icons = [
      'ext-personio-element-list' => 'ext-personio-element-list.svg',
      'ext-personio-element-show' => 'ext-personio-element-list.svg'
    ];    
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
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

  \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Personio',
    'list',
    [
      \Pkd\Personio\Controller\PersonioController::class => 'list',
    ],
    // non-cacheable actions
    [
      \Pkd\Personio\Controller\PersonioController::class => '',
    ]
  );

  \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Personio',
    'show',
    [
      \Pkd\Personio\Controller\PersonioController::class => 'show',
    ],
    // non-cacheable actions
    [
      \Pkd\Personio\Controller\PersonioController::class => '',
    ]
  );

  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    @import \'EXT:personio/Configuration/TsConfig/ContentElementWizard.tsconfig\'
  ');
})();