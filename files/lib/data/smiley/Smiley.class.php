<?php
namespace wcf\data\smiley;
use wcf\data\DatabaseObject;

/**
 * Represents a smiley.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley
 * @category	Community Framework
 */
class Smiley extends DatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'smiley';
	
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'smileyID';
	
	/**
	 * Returns the url to this smiley.
	 * 
	 * @return	string
	 */
	public function getURL() {
		return RELATIVE_WCF_DIR.$this->smileyPath;
	}
}
