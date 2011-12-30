<?php
namespace wcf\data\bbcode\attribute;
use wcf\data\DatabaseObjectList;
use wcf\data\bbcode\BBCode;

/**
 * Represents a list of bbcode attribute.
 * 
 * @author	Tim Düsterhus, Alexander Ebert
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode.attribute
 * @category 	Community Framework
 */
class BBCodeAttributeList extends DatabaseObjectList {
	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\bbcode\attribute\BBCodeAttribute';
	
	/**
	 * Reads attributes by assigned bbcode.
	 *
	 * @param	wcf\data\bbcode\BBCode	$bbcode
	 * @return	array<BBCodeAttribute>
	 */
	public static function getAttributesByBBCode(BBCode $bbcode) {
		$attributeList = new static();
		$attributeList->sqlOrderBy = "bbcode_attribute.attributeNo ASC";
		$attributeList->getConditionBuilder()->add('bbcode_attribute.bbcodeID = ?', array($bbcode->bbcodeID));
		$attributeList->readObjects();
		return $attributeList->getObjects();
	}
}
