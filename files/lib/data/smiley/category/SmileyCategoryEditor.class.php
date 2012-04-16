<?php
namespace wcf\data\smiley\category;
use wcf\data\smiley\SmileyAction;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;
use wcf\system\cache\CacheHandler;
use wcf\system\language\I18nHandler;
use wcf\system\package\PackageDependencyHandler;
use wcf\system\WCF;

/**
 * Provides functions to edit smiley categories.
 *
 * @author	Tim Düsterhus, Alexander Ebert
 * @copyright	2001-2012 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley.category
 * @category 	Community Framework
 */
class SmileyCategoryEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	public static $baseClass = 'wcf\data\smiley\category\SmileyCategory';
	
	/**
	 * @see	\wcf\data\DatabaseObjectEditor::deleteAll()
	 */
	public static function deleteAll(array $objectIDs = array()) {
		WCF::getDB()->beginTransaction();
		// correct showOrder
		$sql = "SELECT	showOrder
			FROM	wcf".WCF_N."_smiley_category
			WHERE	smileyCategoryID = ?
			FOR UPDATE";
		$select = WCF::getDB()->prepareStatement($sql);
		
		$sql = "UPDATE	wcf".WCF_N."_smiley_category
			SET	showOrder = showOrder - 1
			WHERE	showOrder > ?";
		$update = WCF::getDB()->prepareStatement($sql);
		
		// calculate new showOrder value for smilies
		$sql = "SELECT	MAX(showOrder)
			FROM	wcf".WCF_N."_smiley
			WHERE	smileyCategoryID IS NULL
			FOR UPDATE";
		$stmt = WCF::getDB()->prepareStatement($sql);
		$stmt->execute();
		$offset = $stmt->fetchColumn() + 1;
		
		$sql = "SELECT	smileyID
			FROM	wcf".WCF_N."_smiley
			WHERE	smileyCategoryID = ?
			FOR UPDATE";
		$smilies = WCF::getDB()->prepareStatement($sql);
		foreach ($objectIDs as $objectID) {
			// delete i18n values
			I18nHandler::getInstance()->remove('wcf.smiley.category.title'.$objectID, PackageDependencyHandler::getInstance()->getPackageID('com.woltlab.wcf.bbcode'));
			
			// correct showOrder
			$select->execute(array($objectID));
			$update->execute(array($select->fetchColumn()));
			
			// move smileys
			$smilies->execute(array($objectID));
			$structure = array(0 => array());
			while ($structure[0][] = $smilies->fetchColumn());
			
			$smileyAction = new SmileyAction(array(), 'updatePosition', array('data' => array(
				'structure' => $structure,
				'offset' => $offset
			)));
			$smileyAction->executeAction();
			
			$offset += count($structure[0]);
		}
		
		// The transaction is being committed in parent::deleteAll()
		// The beginTransaction() call in there is simply ignored.
		return parent::deleteAll($objectIDs);
	}
	
	/**
	 * @see	wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
		CacheHandler::getInstance()->clear(WCF_DIR.'cache', 'cache.smiley.php');
	}
}
