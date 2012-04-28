<?php
namespace wcf\system\cache\builder;
use \wcf\data\bbcode\media\MediaProviderList;

/**
 * Caches the media-providers.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 - 2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.cache.builder
 * @category 	Community Framework
 */
class BBCodeMediaProviderCacheBuilder implements ICacheBuilder {
	/**
	 * @see	wcf\system\cache\ICacheBuilder::getData()
	 */
	public function getData(array $cacheResource) {
		$providerList = new MediaProviderList();
		$providerList->sqlLimit = 0;
		$providerList->readObjects();
		
		return $providerList;
	}
}
