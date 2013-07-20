<?php
namespace OliverHader\WorkspacesLogger;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Workspaces\ColumnDataProviderInterface;

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
class DataProvider implements SingletonInterface, ColumnDataProviderInterface {

	const TABLE_Name = 'tx_workspaceslogger_event';
	const EVENT_SetStage = 91;

	/**
	 * @return array
	 */
	public function getDefinition() {
		return array('type' => 'int');
	}

	/**
	 * @param \TYPO3\CMS\Workspaces\Domain\Model\CombinedRecord $combinedRecord
	 * @return string|integer|array
	 */
	public function getData(\TYPO3\CMS\Workspaces\Domain\Model\CombinedRecord $combinedRecord) {
		return $this->getLastStageChange($combinedRecord->getTable(), $combinedRecord->getVersiondId());
	}

	/**
	 * @param string $table
	 * @param integer $id
	 * @return NULL|integer
	 */
	protected function getLastStageChange($table, $id) {
		$lastStageChange = NULL;

		$record = $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
			'*',
			self::TABLE_Name,
			'eventtype=' . (int) self::EVENT_SetStage .
				' AND eventtable=' . $this->getDatabaseConnection()->fullQuoteStr($table, self::TABLE_Name) .
				' AND eventuid=' . (int) $id,
			'',
			'valueinteger DESC'
		);

		if (is_array($record)) {
			$lastStageChange = $record['valueinteger'];
		}

		return $lastStageChange;
	}

	/**
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}

}
?>