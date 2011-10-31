<?php
namespace wcf\system\cache\builder;
use wcf\system\WCF;

/**
 * Caches the smilies.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.cache.builder
 * @category 	Community Framework
 */
class SmileyCacheBuilder implements ICacheBuilder {
	/**
	 * @see	wcf\system\cache\ICacheBuilder::getData()
	 */
	public function getData(array $cacheResource) {
		$data = array('categories' => array(), 'smilies' => array());
		
		// get categories
		$sql = "SELECT		smiley_category.*,
					(SELECT COUNT(*) AS count FROM wcf".WCF_N."_smiley WHERE smileyCategoryID = smiley_category.smileyCategoryID) AS smilies
			FROM 		wcf".WCF_N."_smiley_category smiley_category
			ORDER BY 	showOrder";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		while ($object = $statement->fetchObject('wcf\data\smiley\category\SmileyCategory')) {
			$data['categories'][$object->smileyCategoryID] = $object;
		}
		
		// get smilies
		$sql = "SELECT		*
			FROM 		wcf".WCF_N."_smiley
			ORDER BY 	showOrder";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		while ($object = $statement->fetchObject('wcf\data\smiley\Smiley')) {
			$data['smilies'][$object->smileyCategoryID][$object->smileyID] = $object;
		}
		
		return $data;
	}
}
