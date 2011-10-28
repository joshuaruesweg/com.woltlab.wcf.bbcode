<?php
namespace wcf\data\bbcode;
use wcf\data\AbstractDatabaseObjectAction;

/**
 * Executes bbcode-related actions.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode
 * @category 	Community Framework
 */
class BBCodeAction extends AbstractDatabaseObjectAction {
	/**
	 * @see wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\bbcode\BBCodeEditor';
}
