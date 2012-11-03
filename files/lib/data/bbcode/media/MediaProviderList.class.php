<?php
namespace wcf\data\bbcode\media;
use wcf\data\DatabaseObjectList;

/**
 * Represents a list of media-providers.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 - 2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode.media
 * @category	Community Framework
 */
class MediaProviderList extends DatabaseObjectList {
	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\bbcode\media\MediaProvider';
}
