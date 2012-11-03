<?php
namespace wcf\data\bbcode;
use wcf\data\ProcessibleDatabaseObject;
use wcf\system\WCF;

/**
 * Represents a bbcode.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode
 * @category	Community Framework
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
	 * @return	array<wcf\data\bbcode\attribute\BBCodeAttribute>
	 */
	public function getAttributes() {
		if ($this->attributes === null) {
			// get attributes from cache
			$this->data['attributes'] = BBCodeCache::getInstance()->getBBCodeAttributes($this->bbcodeTag);
		}
		
		return $this->attributes;
	}
	
	/**
	 * Returns BBCode-object by tag.
	 *
	 * @param	string					$tag
	 * @return	wcf\data\bbcode\BBCode
	 */
	public static function getBBCodeByTag($tag) {
		$sql = "SELECT	*
			FROM	wcf".WCF_N."_bbcode
			WHERE	bbcodeTag = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($tag));
		$row = $statement->fetchArray();
		if (!$row) $row = array();
		
		return new self(null, $row);
	}
}
