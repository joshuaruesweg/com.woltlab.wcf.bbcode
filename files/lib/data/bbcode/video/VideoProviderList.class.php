<?php
namespace wcf\data\bbcode\video;
use wcf\data\DatabaseObjectList;

/**
 * Represents a list of video-providers.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode.video
 * @category 	Community Framework
 */
class VideoProviderList extends DatabaseObjectList {
	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\bbcode\video\VideoProvider';
}
