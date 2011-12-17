<?php
namespace wcf\data\bbcode;
use wcf\system\cache\CacheHandler;
use wcf\system\SingletonFactory;

/**
 * Manages the bbcode cache.
 * 
 * @author 	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode
 * @category 	Community Framework
 */
class BBCodeCache extends SingletonFactory {
	/**
	 * cached bbcodes
	 * @var	array<wcf\data\bbcode\BBCode>
	 */
	protected $cachedBBCodes = array();
	
	/**
	 * @see	wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		// get bbcode cache
		CacheHandler::getInstance()->addResource('bbcode', WCF_DIR.'cache/cache.bbcode.php', 'wcf\system\cache\builder\BBCodeCacheBuilder');
		$this->cachedBBCodes = CacheHandler::getInstance()->get('bbcode');
	}
	
	/**
	 * Returns all bbcodes.
	 * 
	 * @return	array<wcf\data\bbcode\BBCode>
	 */
	public function getBBCodes() {
		return $this->cachedBBCodes;
	}
	
	/**
	 * Returns all attributes of a bbcode.
	 * 
	 * @param	string		$tag
	 * @return 	array<wcf\data\bbcode\attribute\BBCodeAttribute>
	 */
	public function getBBCodeAttributes($tag) {
		return $this->cachedBBCodes[$tag]->getAttributes();
	}
}
