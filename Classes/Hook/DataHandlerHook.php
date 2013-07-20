<?php
namespace OliverHader\WorkspacesLogger\Hook;
use TYPO3\CMS\Core\SingletonInterface;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Oliver Hader <oliver.hader@typo3.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @author Oliver Hader <oliver.hader@typo3.org>
 */
class DataHandlerHook implements SingletonInterface {

	const TABLE_Name = 'tx_workspaceslogger_event';
	const EVENT_SetStage = 91;

	/**
	 * hook that is called when no prepared command was found
	 *
	 * @param string $command the command to be executed
	 * @param string $table the table of the record
	 * @param integer $id the ID of the record
	 * @param mixed $value the value containing the data
	 * @param boolean $commandIsProcessed can be set so that other hooks or
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $tcemainObj reference to the main tcemain object
	 * @return 	void
	 */
	public function processCmdmap($command, $table, $id, $value, &$commandIsProcessed, \TYPO3\CMS\Core\DataHandling\DataHandler $tcemainObj) {
		$action = (string) $value['action'];
		if ($command === 'version' && $action === 'setStage' && $commandIsProcessed) {
				$elementIds = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $id, TRUE);
				foreach ($elementIds as $elementId) {
					$this->persistStageChange($table, $elementId);
				}
		}
	}

	protected function persistStageChange($table, $id) {
		$fields = array(
			'eventtype' => self::EVENT_SetStage,
			'eventtable' => $table,
			'eventuid' => $id,
			'valueinteger' => $GLOBALS['EXEC_TIME'],
		);

		$this->getDatabaseConnection()->exec_INSERTquery(
			self::TABLE_Name, $fields
		);
	}

	/**
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}

}
?>