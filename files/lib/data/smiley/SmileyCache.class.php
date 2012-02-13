<?php
namespace wcf\data\smiley;
use wcf\system\cache\CacheHandler;
use wcf\system\SingletonFactory;

/**
 * Manages the smiley cache.
 * 
 * @author 	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley
 * @category 	Community Framework
 */
class SmileyCache extends SingletonFactory {
	/**
	 * cached smilies
	 * @var	array
	 */
	protected $cachedSmilies = array();
	
	/**
	 * cached smiley categories
	 * @var	array<wcf\data\smiley\category\SmileyCategory>
	 */
	protected $cachedCategories = array();
	
	/**
	 * @see	wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		// get smiley cache
		CacheHandler::getInstance()->addResource('smiley', WCF_DIR.'cache/cache.smiley.php', 'wcf\system\cache\builder\SmileyCacheBuilder');
		$this->cachedSmilies = CacheHandler::getInstance()->get('smiley', 'smilies');
		$this->cachedCategories = CacheHandler::getInstance()->get('smiley', 'categories');
	}
	
	/**
	 * Returns all smilies.
	 * 
	 * @return	array
	 */
	public function getSmilies() {
		return $this->cachedSmilies;
	}
	
	/**
	 * Returns all smiley categories.
	 * 
	 * @return	array<wcf\data\smiley\category\SmileyCategory>
	 */
	public function getCategories() {
		return $this->cachedCategories;
	}
	
	/**
	 * Returns all the smilies of a category.
	 * 
	 * @param	integer		$categoryID
	 * @return	array
	 */
	public function getCategorySmilies($categoryID = null) {
		if (isset($this->cachedSmilies[$categoryID])) return $this->cachedSmilies[$categoryID];
		
		return array();
	}
}
