<?php
namespace wcf\data\bbcode;
use wcf\data\ProcessibleDatabaseObject;

/**
 * Represents a bbcode.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode
 * @category 	Community Framework
 */
class BBCode extends ProcessibleDatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'bbcode';
	
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'bbcodeID';
	
	/**
	 * @see	wcf\data\ProcessibleDatabaseObject::$processorInterface
	 */
	protected static $processorInterface = 'wcf\system\bbcode\IBBCode';
	
	/**
	 * Returns the attributes of this bbcode.
	 * 
	 * @return array<wcf\data\bbcode\attribute\BBCodeAttribute>
	 */
	public function getAttributes() {
		if ($this->attributes === null) {
			// get attributes from cache
			$this->data['attributes'] = BBCodeCache::getInstance()->getBBCodeAttributes($this->bbcodeTag);
		}
		
		return $this->attributes;
	}
}
