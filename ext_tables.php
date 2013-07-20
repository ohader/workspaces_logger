<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Workspaces\Service\AdditionalColumnService::getInstance()->register(
	'WorkspacesLogger_StageChange',
	'OliverHader\\WorkspacesLogger\\DataProvider'
);

\TYPO3\CMS\Workspaces\Service\AdditionalResourceService::getInstance()->addJavaScriptResource(
	'WorkspacesLogger',
	'EXT:workspaces_logger/Resources/Public/JavaScript/StageChange.js'
);
?>