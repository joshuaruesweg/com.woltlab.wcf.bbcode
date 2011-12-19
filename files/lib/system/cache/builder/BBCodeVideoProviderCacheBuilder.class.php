<?php
namespace wcf\system\cache\builder;
use \wcf\data\bbcode\video\VideoProviderList;

/**
 * Caches the video-providers.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.cache.builder
 * @category 	Community Framework
 */
class BBCodeVideoProviderCacheBuilder implements ICacheBuilder {
	/**
	 * @see	wcf\system\cache\ICacheBuilder::getData()
	 */
	public function getData(array $cacheResource) {
		$providerList = new VideoProviderList();
		$providerList->sqlLimit = 0;
		$providerList->readObjects();
		
		return $providerList;
	}
}
