<?php
defined('TYPO3_MODE') || die();

(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'personio',
        'Configuration/TypoScript',
        'Personio'
    );
})();
