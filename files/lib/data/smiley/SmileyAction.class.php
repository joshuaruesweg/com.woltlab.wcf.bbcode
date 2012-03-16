<?php
namespace wcf\data\smiley;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\WCF;

/**
 * Executes smiley-related actions.
 * 
 * @author	Tim Düsterhus, Alexander Ebert
 * @copyright	2001-2012 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley
 * @category 	Community Framework
 */
class SmileyAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\smiley\SmileyEditor';
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.content.smiley.canDeleteSmiley');
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array('admin.content.smiley.canEditSmiley');
	
	/**
	 * Validates parameters to update sorting.
	 */
	public function validateUpdatePosition() {
		// validate permissions
		if (is_array($this->permissionsUpdate) && count($this->permissionsUpdate)) {
			try {
				WCF::getSession()->checkPermissions($this->permissionsUpdate);
			}
			catch (\wcf\system\exception\PermissionDeniedException $e) {
				throw new ValidateActionException('Insufficient permissions');
			}
		}
		else {
			throw new ValidateActionException('Insufficient permissions');
		}
		
		if (!isset($this->parameters['data']['structure'])) {
			throw new ValidateActionException('Missing parameter structure');
		}
		
		if (!isset($this->parameters['data']['offset'])) $this->parameters['data']['offset'] = 0;
	}
	
	/**
	 * Updates sorting.
	 */
	public function updatePosition() {
		$smileyList = new SmileyList();
		$smileyList->sqlOrderBy = "smiley.showOrder";
		$smileyList->sqlLimit = 0;
		$smileyList->readObjects();
		
		$i = $this->parameters['data']['offset'];
		WCF::getDB()->beginTransaction();
		foreach ($this->parameters['data']['structure'][0] as $smileyID) {
			$smiley = $smileyList->search($smileyID);
			if ($smiley === null) continue;
			$editor = new SmileyEditor($smiley);
			$editor->update(array('showOrder' => $i++));
		}
		WCF::getDB()->commitTransaction();
	}
}
