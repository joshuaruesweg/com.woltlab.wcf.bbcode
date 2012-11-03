<?php
namespace wcf\data\bbcode;
use wcf\data\AbstractDatabaseObjectAction;

/**
 * Executes bbcode-related actions.
 * 
 * @author	Tim Düsterhus, Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode
 * @category	Community Framework
 */
class BBCodeAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\bbcode\BBCodeEditor';
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
	 */
	protected $permissionsDelete = array('admin.content.bbcode.canDeleteBBCode');
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
	 */
	protected $permissionsUpdate = array('admin.content.bbcode.canEditBBCode');
	
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
		foreach ($this->objects as $bbcode) {
			$newStatus = (int) !$bbcode->disabled;
			$bbcode->update(array('disabled' => $newStatus));
		}
	}
}
