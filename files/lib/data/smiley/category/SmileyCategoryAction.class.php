<?php
namespace wcf\data\smiley\category;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\WCF;

/**
 * Executes smiley category-related actions.
 * 
 * @author	Tim Düsterhus, Alexander Ebert
 * @copyright	2001-2012 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley.category
 * @category 	Community Framework
 */
class SmileyCategoryAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\smiley\category\SmileyCategoryEditor';
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.content.smiley.canDeleteSmiley');
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array('admin.content.smiley.canEditSmiley');
	
	/**
	 * Fixes create to append new categories.
	 */
	public function create() {
		$category = parent::create();
		
		WCF::getDB()->beginTransaction();
		$sql = "SELECT		max(showOrder) as max
			FROM		wcf".WCF_N."_smiley_category
			FOR UPDATE";
		$stmt = WCF::getDB()->prepareStatement($sql);
		$stmt->execute();
		
		$sql = "UPDATE	wcf".WCF_N."_smiley_category
			SET	showOrder = ".($stmt->fetchColumn() + 1)."
			WHERE	smileyCategoryID = ?";
		$stmt = WCF::getDB()->prepareStatement($sql);
		$stmt->execute(array($category->smileyCategoryID));
		WCF::getDB()->commitTransaction();
		
		return $category;
	}
	
	/**
	 * Validates permissions and parameters
	 */
	public function validateToggle() {
		parent::validateUpdate();
	}
	
	/**
	 * Toggles status.
	 */
	public function toggle() {
		foreach ($this->objects as $category) {
			$newStatus = (int) !$category->disabled;
			$category->update(array('disabled' => $newStatus));
		}
	}
	
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
	}
	
	/**
	 * Updates sorting.
	 */
	public function updatePosition() {
		$categoryList = new SmileyCategoryList();
		$categoryList->sqlOrderBy = "smiley_category.showOrder";
		$categoryList->sqlLimit = 0;
		$categoryList->readObjects();
		
		$i = 0;
		WCF::getDB()->beginTransaction();
		foreach ($this->parameters['data']['structure'][0] as $categoryID) {
			$category = $categoryList->search($categoryID);
			if ($category === null) continue;
			$editor = new SmileyCategoryEditor($category);
			$editor->update(array('showOrder' => $i++));
		}
		WCF::getDB()->commitTransaction();
	}
}
