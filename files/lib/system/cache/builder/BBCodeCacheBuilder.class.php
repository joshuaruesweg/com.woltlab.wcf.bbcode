<?php
namespace wcf\system\cache\builder;
use wcf\data\bbcode\attribute\BBCodeAttribute;
use wcf\data\bbcode\BBCode;
use wcf\system\WCF;

/**
 * Caches the bbcodes.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.cache.builder
 * @category	Community Framework
 */
class BBCodeCacheBuilder implements ICacheBuilder {
	/**
	 * @see	wcf\system\cache\ICacheBuilder::getData()
	 */
	public function getData(array $cacheResource) {
		$data = $attributes = array();
		
		// get attributes
		$sql = "SELECT		attribute.*, bbcode.bbcodeTag
			FROM		wcf".WCF_N."_bbcode_attribute attribute
			LEFT JOIN	wcf".WCF_N."_bbcode bbcode
			ON		(bbcode.bbcodeID = attribute.bbcodeID)
			WHERE		bbcode.disabled = 0
			ORDER BY	attribute.attributeNo";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		while ($row = $statement->fetchArray()) {
			if (!isset($attributes[$row['bbcodeTag']])) $attributes[$row['bbcodeTag']] = array();
			
			$attributes[$row['bbcodeTag']][$row['attributeNo']] = new BBCodeAttribute(null, $row);
		}
		
		// get bbcodes
		$sql = "SELECT	*
			FROM	wcf".WCF_N."_bbcode
			WHERE	disabled = 0";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		while ($row = $statement->fetchArray()) {
			$row['attributes'] = (isset($attributes[$row['bbcodeTag']]) ? $attributes[$row['bbcodeTag']] : array());
			$data[$row['bbcodeTag']] = new BBCode(null, $row);
		}
		
		return $data;
	}
}
