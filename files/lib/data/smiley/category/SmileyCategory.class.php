<?php
namespace wcf\data\smiley\category;
use wcf\data\DatabaseObject;
use wcf\system\WCF;

/**
 * Represents a smiley category.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley.category
 * @category 	Community Framework
 */
class SmileyCategory extends DatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'smiley_category';
	
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'smileyCategoryID';
	
	/**
	 * @see wcf\data\DatabaseObject::__construct()
	 */
	public function __construct($id, array $row = null, DatabaseObject $object = null) {
		if ($id !== null) {
			$sql = "SELECT	(SELECT COUNT(*) FROM wcf".WCF_N."_smiley WHERE smileyCategoryID = smiley_category.smileyCategoryID) AS smileyCount,
					smiley_category.*
				FROM	".static::getDatabaseTableName()." smiley_category
				WHERE	smiley_category.".static::getDatabaseTableIndexName()." = ?";
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute(array($id));
			$row = $statement->fetchArray();
			
			// enforce data type 'array'
			if ($row === false) $row = array();
		}
		else if ($object !== null) {
			$row = $object->data;
		}
		
		$this->handleData($row);
	}
}
