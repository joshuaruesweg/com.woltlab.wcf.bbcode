<?php
namespace wcf\data\smiley;
use wcf\data\AbstractDatabaseObjectAction;

/**
 * Executes smiley-related actions.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
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
}
