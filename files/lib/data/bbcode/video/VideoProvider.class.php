<?php
namespace wcf\data\bbcode\video;
use wcf\data\DatabaseObject;
use wcf\system\cache\CacheHandler;
use wcf\util\StringUtil;

/**
 * Represents a video provider.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode.video
 * @category 	Community Framework
 */
class VideoProvider extends DatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'bbcode_video_provider';
	
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'providerID';
	
	/**
	 * Caches providers.
	 * 
	 * @var	array<\wcf\data\bbcode\video\VideoProvider>
	 */
	protected static $cache = null;
	
	/**
	 * Loads the provider cache.
	 */
	public static function getCache() {
		if (self::$cache === null) {
			CacheHandler::getInstance()->addResource(
				'videoproviders',
				WCF_DIR.'cache/cache.videoproviders.php',
				'wcf\system\cache\builder\BBCodeVideoProviderCacheBuilder'
			);
			self::$cache = CacheHandler::getInstance()->get('videoproviders');
		}
		
		return self::$cache;
	}
	
	/**
	 * Checks whether this provider matches the given URL.
	 *
	 * @param	string	$url
	 * @return	boolean
	 */
	public function matches($url) {
		return preg_match($this->regex, $url);
	}
	
	/**
	 * Returns the html for this provider.
	 *
	 * @param	string	$url
	 * @return	string
	 */
	public function getOutput($url) {
		if (!preg_match($this->regex, $url, $matches)) return '';
		
		$output = $this->html;
		foreach ($matches as $name => $value) {
			$output = StringUtil::replace('{$'.$name.'}', $value, $output);
		}
		return $output;
	}
}
